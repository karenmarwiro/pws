<?php

namespace App\Core\Controllers;

use App\Core\Controllers\AdminController;
use CodeIgniter\API\ResponseTrait;
use App\Core\Models\ModulesModels;

class Modules extends AdminController
{
    protected $modulesModel;
    
    public function __construct()
    {
        $this->modulesModel = new \App\Core\Models\ModulesModel();
        helper(['form', 'url']);
    }
    public function add()
    {
        $data = [
            'title' => 'Add New Module',
        ];

        return $this->coreView('Modules/add', $data);
    }

    public function index()
    {
        $modules = $this->modulesModel->findAll();
    
        return $this->coreView('Modules/index', [
            'title'   => 'Modules Management',
            'modules' => $modules
        ]);
    }       
    
    protected function ensureCoreModulesExist()
    {
        $moduleModel = new \App\Core\Models\ModuleModel();
    
        $coreModules = [
            ['name' => 'Settings', 'description' => 'System configuration and preferences', 'version' => '1.0.0', 'is_active' => true, 'is_core' => true, 'icon' => 'fas fa-cog'],
            ['name' => 'Modules',  'description' => 'Manage system modules', 'version' => '1.0.0', 'is_active' => true, 'is_core' => true, 'icon' => 'fas fa-puzzle-piece'],
            ['name' => 'RBAC',     'description' => 'Role-Based Access Control', 'version' => '1.0.0', 'is_active' => true, 'is_core' => true, 'icon' => 'fas fa-user-shield']
        ];
    
        foreach ($coreModules as $module) {
            $existing = $moduleModel->where('name', $module['name'])->first();
    
            if (!$existing) {
                // Insert if missing
                $moduleModel->insert($module);
            } elseif (!$existing['is_core']) {
                // Ensure existing module is marked as core
                $moduleModel->update($existing['id'], ['is_core' => true]);
            }
        }
    }
    
    

    public function upload()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }
    
        $file = $this->request->getFile('module_zip');
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $file ? $file->getErrorString() : 'No file uploaded.'
            ]);
        }
    
        // Only allow ZIP
        if (!in_array($file->getClientMimeType(), ['application/zip', 'application/x-zip-compressed'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Only ZIP files are allowed.'
            ]);
        }
    
        $uploadPath = ROOTPATH . 'app/modules/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
    
        $moduleName = $this->request->getPost('module_name') ?: pathinfo($file->getName(), PATHINFO_FILENAME);
        $moduleName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $moduleName);
        $moduleDir  = $uploadPath . $moduleName;
    
        // Ensure unique folder
        $counter = 1;
        while (is_dir($moduleDir)) {
            $moduleDir = $uploadPath . $moduleName . '_' . $counter++;
        }
        mkdir($moduleDir, 0777, true);
    
        $zipPath = $moduleDir . '.zip';
        if (!$file->move(dirname($zipPath), basename($zipPath))) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to save uploaded file.'
            ]);
        }
    
        // Extract ZIP
        $zip = new \ZipArchive();
        if ($zip->open($zipPath) !== true) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Could not open ZIP archive.'
            ]);
        }
        $zip->extractTo($moduleDir);
        $zip->close();
        @unlink($zipPath);
    
        // Save module info
        $moduleModel = new \App\Models\ModuleModel();
        $saved = $moduleModel->insert([
            'name'        => $moduleName,
            'description' => $this->request->getPost('module_description') ?: 'Custom module',
            'version'     => $this->request->getPost('module_version') ?: '1.0.0',
            'is_active'   => 0,
            'is_core'     => 0,
            'icon'        => 'fas fa-puzzle-piece',
            'created_at'  => date('Y-m-d H:i:s')
        ]);
    
        if ($saved) {
            return $this->response->setJSON([
                'success'  => true,
                'message'  => 'Module installed successfully!',
                'redirect' => site_url('modules')
            ]);
        }
    
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to save module to database.'
        ]);
    }
    


    /**
     * Recursively remove a directory
     * 
     * @param string $dir Directory path to remove
     * @return bool True on success, false on failure
     */
    private function rrmdir($dir)
{
    if (!is_dir($dir)) {
        return false;
    }

    $files = array_diff(scandir($dir), ['.', '..']);

    foreach ($files as $file) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            $this->rrmdir($path);
        } else {
            unlink($path);
        }
    }

    return rmdir($dir);
}


    /**
     * Convert string to StudlyCase
     */
    private function toStudlyCase($string)
{
    // Replace underscores and dashes with spaces
    $string = str_replace(['_', '-'], ' ', $string);

    // Capitalize each word
    $string = ucwords($string);

    // Remove spaces
    return str_replace(' ', '', $string);
}

    
    /**
     * Convert string to Title Case
     */
    private function toTitleCase($string)
    {
        return ucwords(str_replace(['_', '-'], ' ', $string));
    }
    
    /**
     * Move all files and directories from one directory to another
     */
    private function moveContentsUp($source, $destination)
{
    foreach (scandir($source) as $file) {
        if (in_array($file, ['.', '..'])) {
            continue;
        }

        $src  = $source . DIRECTORY_SEPARATOR . $file;
        $dest = $destination . DIRECTORY_SEPARATOR . $file;

        if (is_dir($src) && is_dir($dest)) {
            // Merge directories recursively
            $this->moveContentsUp($src, $dest);
            @rmdir($src);
        } else {
            rename($src, $dest);
        }
    }
}


    public function edit($id)
    {
        // Sample module data - replace with your actual data fetching
        $modules = $this->modulesModel->find($id);

        if (!$modules) {
            return redirect()->to('/modules')->with('error', 'Module not found');
        }

        $data = [
            'title' => 'Edit Module',
            'module' => $modules,
            'coreViewPath' => $this->coreViewPath
        ];

        return $this->coreView('Modules/edit', $data);
    }

    public function update($id)
{
    $rules = [
        'name'        => 'required|min_length[3]|max_length[100]',
        'version'     => 'required|min_length[1]|max_length[20]',
        'description' => 'required|min_length[10]|max_length[500]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $data = [
        'name'        => $this->request->getPost('name'),
        'version'     => $this->request->getPost('version'),
        'description' => $this->request->getPost('description'),
        'author'      => $this->request->getPost('author'),
        'icon'        => $this->request->getPost('icon'),
        'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        'updated_at'  => date('Y-m-d H:i:s')
    ];

    $moduleModel = new \App\Models\ModuleModel();
    $moduleModel->update($id, $data);

    return redirect()->to('/modules')->with('success', 'Module updated successfully');
}


public function delete($id = null)
{
    if (!$id || !is_numeric($id)) {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid module ID']);
        }
        return redirect()->back()->with('error', 'Invalid module ID');
    }

    $id = (int) $id;
    $moduleModel = new \App\Models\ModuleModel();
    $module = $moduleModel->find($id);

    if (!$module) {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Module not found']);
        }
        return redirect()->back()->with('error', 'Module not found');
    }

    if (!empty($module['is_core'])) {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cannot delete core modules']);
        }
        return redirect()->back()->with('error', 'Cannot delete core modules');
    }

    $moduleName = $module['name'];
    $modulePath = ROOTPATH . 'app/modules/' . $moduleName;

    if (is_dir($modulePath)) {
        $this->rrmdir($modulePath);
    }

    $moduleModel->delete($id);

    // ✅ AJAX response
    if ($this->request->isAJAX()) {
        return $this->response->setJSON(['success' => true, 'message' => 'Module deleted successfully']);
    }

    // ✅ Fallback for normal form
    return redirect()->to('/modules')->with('success', 'Module deleted successfully');
}

     
    public function enableModule()
    {
        $moduleName = $this->request->getJSON(true)['module'] ?? null;
    
        if (!$moduleName) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Module name required'
            ]);
        }
    
        $moduleName = str_replace('_', ' ', $moduleName);
        $moduleName = ucwords($moduleName);
    
        $moduleModel = new \App\Models\ModuleModel();
        $module = $moduleModel->where('name', $moduleName)->first();
    
        if (!$module) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Module not found'
            ]);
        }
    
        $moduleModel->update($module['id'], ['is_active' => 1]);
    
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Module enabled successfully',
            'data' => ['id' => $module['id'], 'is_active' => true]
        ]);
    }
    
    /**
     * Disable a module
     */
    public function disableModule()
    {
        $moduleName = $this->request->getJSON(true)['module'] ?? null;
    
        if (!$moduleName) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Module name required'
            ]);
        }
    
        $moduleName = str_replace('_', ' ', $moduleName);
        $moduleName = ucwords($moduleName);
    
        $moduleModel = new \App\Models\ModuleModel();
        $module = $moduleModel->where('name', $moduleName)->first();
    
        if (!$module) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Module not found'
            ]);
        }
    
        if (!empty($module['is_core'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Cannot disable core modules'
            ]);
        }
    
        $moduleModel->update($module['id'], ['is_active' => 0]);
    
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Module disabled successfully',
            'data' => ['id' => $module['id'], 'is_active' => false]
        ]);
    }
    
    
    /**
     * Toggle module active status
     */
    public function toggle($id = null)
{
    if (!$this->request->isAJAX()) {
        return $this->response->setStatusCode(405)->setJSON([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
    }

    $moduleModel = new \App\Models\ModuleModel();
    $module = $moduleModel->find($id);

    if (!$module) {
        return $this->response->setStatusCode(404)->setJSON([
            'success' => false,
            'message' => 'Module not found'
        ]);
    }

    $request = $this->request->getJSON(true) ?? [];
    $enable = $request['enable'] ?? !$module['is_active'];

    if ($module['is_core'] && !$enable) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Cannot deactivate core modules'
        ]);
    }

    $moduleModel->update($id, ['is_active' => $enable ? 1 : 0]);

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Module ' . ($enable ? 'activated' : 'deactivated') . ' successfully',
        'data' => [
            'id' => $id,
            'is_active' => (bool) $enable
        ]
    ]);
}

protected function runModuleMigrations(string $moduleName)
{
    $migrationsPath = APPPATH . "Modules/{$moduleName}/Database/Migrations";

    if (!is_dir($migrationsPath)) {
        log_message('debug', "No migrations found for module {$moduleName}");
        return;
    }

    $migrate = \Config\Services::migrations();

    try {
        // Tell CI where to look for migrations
        $migrate->setNamespace("App\\Modules\\{$moduleName}");
        $migrate->latest();
        log_message('debug', "Migrations for module {$moduleName} executed successfully.");
    } catch (\Throwable $e) {
        log_message('error', "Migration failed for {$moduleName}: " . $e->getMessage());
        throw $e;
    }
}

}