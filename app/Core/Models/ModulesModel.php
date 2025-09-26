<?php

namespace App\Core\Models;

use CodeIgniter\Model;

class ModulesModel extends Model
{
    protected $table            = 'modules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;
    protected $useSoftDeletes   = false;
    protected $allowCallbacks = true;
    protected $allowedFields    = [
        'name', 
        'description', 
        'version', 
        // 'namespace',  // Temporarily removed until column is added
        // 'path',       // Temporarily removed until column is added
        'is_active', 
        'is_core', 
        'icon',
        'author',
        'order',
        'settings',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    
    // Validation rules
    protected $validationRules = [
        'name'      => 'required|min_length[3]|is_unique[modules.name,id,{id}]',
        'version'   => 'required',
        // 'namespace' => 'required',  // Temporarily removed until column is added
        'is_active' => 'permit_empty|in_list[0,1]',
        'is_core'   => 'permit_empty|in_list[0,1]',
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Module name is required',
            'min_length' => 'Module name must be at least 3 characters long',
            'is_unique' => 'A module with this name already exists'
        ],
        'version' => [
            'required' => 'Module version is required'
        ],
        'namespace' => [
            'required' => 'Module namespace is required'
        ]
    ];
    
    protected $beforeInsert = ['jsonEncodeSettings'];
    protected $beforeUpdate = ['jsonEncodeSettings'];
    protected $afterFind    = ['jsonDecodeSettings'];
    
    protected function jsonEncodeSettings(array $data)
    {
        if (isset($data['data']['settings']) && is_array($data['data']['settings'])) {
            $data['data']['settings'] = json_encode($data['data']['settings']);
        }
        return $data;
    }
    
    protected function jsonDecodeSettings(array $data)
    {
        if (!is_array($data['data'])) {
            return $data;
        }
        
        if (is_array($data['data'])) {
            foreach ($data['data'] as &$row) {
                if (isset($row['settings']) && is_string($row['settings'])) {
                    $row['settings'] = json_decode($row['settings'], true) ?? [];
                }
            }
        } elseif (isset($data['data']['settings']) && is_string($data['data']['settings'])) {
            $data['data']['settings'] = json_decode($data['data']['settings'], true) ?? [];
        }
        
        return $data;
    }

    // Toggle module active status
    public function toggleStatus($id)
    {
        $module = $this->find($id);
        if (!$module) {
            return false;
        }

        $this->update($id, ['is_active' => !$module['is_active']]);
        return true;
    }
}