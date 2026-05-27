<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Installer;
use App\Core\Session;

class InstallController extends Controller
{
    public function index(): void
    {
        if (Database::isReady()) {
            $this->view('install/done', ['title' => 'Already Installed']);
            return;
        }
        $this->view('install/index', ['title' => 'Install Database']);
    }

    public function run(): void
    {
        try {
            $result = Installer::run();
            Session::flash('success', $result['message']);
            $this->redirect('/login');
        } catch (\Throwable $e) {
            Session::flash('error', 'Install failed: ' . $e->getMessage());
            $this->redirect('/install');
        }
    }
}
