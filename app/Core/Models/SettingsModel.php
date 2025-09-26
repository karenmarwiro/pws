<?php

namespace App\Core\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['class', 'key', 'value', 'type', 'context', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get all settings as an associative array
     *
     * @param bool $forceRefresh If true, will ignore any cached settings
     * @return array
     */
    public function getAllSettings($forceRefresh = false)
    {
        $cacheKey = 'app_settings_all';
        
        // Try to get from cache first if not forcing refresh
        if (!$forceRefresh && function_exists('cache') && $cached = cache($cacheKey)) {
            return $cached;
        }
        
        $settings = [];
        $result = $this->findAll();
        
        if (empty($result)) {
            return [];
        }
        
        foreach ($result as $row) {
            if (!empty($row['key'])) {  // Ensure we have a valid key
                $settings[$row['key']] = $this->unserializeIfNeeded($row['value'], $row['type'] ?? 'string');
            }
        }
        
        // Cache the results for better performance
        if (function_exists('cache')) {
            cache()->save($cacheKey, $settings, 3600); // Cache for 1 hour
        }
        
        return $settings;
    }

    /**
     * Get settings by group
     *
     * @param string $group
     * @return array
     */
    public function getSettingsByGroup($group)
    {
        $settings = [];
        $result = $this->where('context', $group)->findAll();
        
        foreach ($result as $row) {
            $settings[$row['key']] = $this->unserializeIfNeeded($row['value'], $row['type'] ?? 'string');
        }
        
        return $settings;
    }

    /**
     * Get a single setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getSetting($key, $default = null)
    {
        $setting = $this->where('`key`', $key)->first();
        return $setting ? $this->unserializeIfNeeded($setting['value'], $setting['type'] ?? 'string') : $default;
    }

    /**
     * Save a setting
     *
     * @param string $key
     * @param mixed $value
     * @param string $class
     * @param string $type
     * @param string $context
     * @return bool|int|string
     */
    public function setSetting($key, $value, $class = 'App', $type = null, $context = 'general')
    {
        if ($type === null) {
            $type = $this->determineType($value);
        }

        $data = [
            'class' => $class,
            'key' => $key,
            'value' => $this->serializeIfNeeded($value, $type),
            'type' => $type,
            'context' => $context,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $existing = $this->where('`key`', $key)->first();
        
        if ($existing) {
            $result = $this->update($existing['id'], $data);
            return $result ? $existing['id'] : false;
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $result = $this->insert($data);
            return $result ? $this->db->insertID() : false;
        }
    }

    /**
     * Save multiple settings at once
     *
     * @param array $settings
     * @param string $class
     * @param string $context
     * @return bool
     */
    public function setSettings($settings, $class = 'App', $context = 'general')
    {
        if (!is_array($settings) || empty($settings)) {
            log_message('error', 'Invalid settings array provided to setSettings()');
            return false;
        }

        $this->db->transBegin();
        
        $results = [];
        foreach ($settings as $key => $value) {
            if (empty($key)) {
                log_message('error', 'Empty key encountered in settings array');
                continue;
            }
            
            $type = $this->determineType($value);
            $result = $this->setSetting($key, $value, $class, $type, $context);
            
            if ($result === false) {
                log_message('error', "Failed to save setting: {$key}");
                $this->db->transRollback();
                return false;
            }
            
            $results[$key] = $result;
        }
        
        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            log_message('error', 'Transaction failed while saving settings');
            return false;
        }
        
        $this->db->transCommit();
        
        // Clear the query builder cache
        if (method_exists($this->db, 'resetQuery')) {
            $this->db->resetQuery();
        }
        
        return true;
    }
    
    /**
     * Determine the type of a value
     *
     * @param mixed $value
     * @return string
     */
    protected function determineType($value)
    {
        if (is_bool($value)) {
            return 'bool';
        }
        
        if (is_int($value)) {
            return 'int';
        }
        
        if (is_float($value)) {
            return 'float';
        }
        
        if (is_array($value) || is_object($value)) {
            return 'json';
        }
        
        return 'string';
    }

    /**
     * Delete a setting by key
     *
     * @param string $key
     * @return bool
     */
    public function deleteSetting($key)
    {
        $result = $this->where('`key`', $key)->delete();
        
        // Clear the cache after deletion
        if ($result && function_exists('cache')) {
            cache()->delete('app_settings_all');
        }
        
        return $result;
    }

    /**
     * Serialize arrays and objects for storage
     *
     * @param mixed $value
     * @return string
     */
    protected function serializeIfNeeded($value, $type = 'string')
    {
        if ($type === 'json' && (is_array($value) || is_object($value))) {
            return json_encode($value);
        }
        
        if ($type === 'bool') {
            return $value ? '1' : '0';
        }
        
        return (string)$value;
    }

    /**
     * Unserialize data if it's serialized
     *
     * @param string $value
     * @return mixed
     */
    protected function unserializeIfNeeded($value, $type = 'string')
    {
        if ($type === 'json' && is_string($value)) {
            return json_decode($value, true) ?? $value;
        }
        
        if ($type === 'bool') {
            return (bool)$value;
        }
        
        if ($type === 'int') {
            return (int)$value;
        }
        
        if ($type === 'float') {
            return (float)$value;
        }
        
        return $value;
    }
}
