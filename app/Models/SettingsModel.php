<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['class', 'key', 'value', 'type', 'context'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get a setting value by key
     */
    public function getSetting($key, $default = null, $class = 'App')
    {
        $setting = $this->where(['key' => $key, 'class' => $class])->first();
        if (!$setting) {
            return $default;
        }
        
        // Convert the value based on type
        $value = $setting['value'];
        switch ($setting['type']) {
            case 'int':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'bool':
                return (bool) $value;
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    /**
     * Save a setting
     */
    public function setSetting($key, $value, $class = 'App', $type = null, $context = null)
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
            $type = 'json';
        } elseif (is_bool($value)) {
            $value = $value ? '1' : '0';
            $type = 'bool';
        } elseif (is_int($value)) {
            $type = 'int';
        } elseif (is_float($value)) {
            $type = 'float';
        } elseif ($type === null) {
            $type = 'string';
        }

        $data = [
            'class' => $class,
            'key' => $key,
            'value' => (string) $value,
            'type' => $type,
            'context' => $context
        ];

        $existing = $this->where(['key' => $key, 'class' => $class])->first();
        
        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            return $this->insert($data);
        }
    }

    /**
     * Get all settings as an associative array
     */
    public function getAllSettings($class = 'App')
    {
        $settings = [];
        $results = $this->where('class', $class)->findAll();
        
        foreach ($results as $row) {
            $value = $row['value'];
            
            // Convert the value based on type
            switch ($row['type']) {
                case 'int':
                    $value = (int) $value;
                    break;
                case 'float':
                    $value = (float) $value;
                    break;
                case 'bool':
                    $value = (bool) $value;
                    break;
                case 'json':
                    $decoded = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $value = $decoded;
                    }
                    break;
            }
            
            $settings[$row['key']] = $value;
        }
        
        return $settings;
    }

    /**
     * Save multiple settings at once
     */
    public function saveSettings(array $settings, $class = 'App', $context = null)
    {
        foreach ($settings as $key => $value) {
            $type = null;
            if (is_array($value) && isset($value['value']) && isset($value['type'])) {
                $type = $value['type'];
                $value = $value['value'];
            }
            $this->setSetting($key, $value, $class, $type, $context);
        }
        return true;
    }
}
