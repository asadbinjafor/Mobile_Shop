<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;

class SettingsController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('settings.view');
        $rows = Database::connection()->query('SELECT * FROM settings')->fetchAll();
        $settings = [];
        foreach ($rows as $r) {
            $settings[$r['setting_key']] = $r['setting_value'];
        }
        $this->view('admin/settings', [
            'title' => 'System Settings',
            'layout' => 'admin',
            'settings' => $settings,
        ]);
    }

    public function save(): void
    {
        $this->requirePermission('settings.update');
        $pdo = Database::connection();
        $stmt = $pdo->prepare('INSERT INTO settings (setting_key, setting_value) VALUES (?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)');
        foreach ($_POST as $key => $value) {
            if (str_starts_with($key, 'setting_')) {
                $stmt->execute([substr($key, 8), trim($value)]);
            }
        }
        $this->redirect('/admin/settings', 'Settings saved.');
    }
}
