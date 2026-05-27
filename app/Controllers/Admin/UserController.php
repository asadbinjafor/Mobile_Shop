<?php
namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\UserModel;

class UserController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('users.view');
        $this->view('admin/users/index', [
            'title' => 'User Management',
            'layout' => 'admin',
            'users' => UserModel::all(),
        ]);
    }

    public function createForm(): void
    {
        $this->requirePermission('users.create');
        $this->view('admin/users/form', [
            'title' => 'Add User',
            'layout' => 'admin',
            'user' => null,
        ]);
    }

    public function create(): void
    {
        $this->requirePermission('users.create');
        $role = $_POST['role'] ?? 'customer';
        if (!in_array($role, ['admin', 'moderator', 'customer'], true)) {
            $role = 'customer';
        }
        if ($role === 'admin' && !Auth::isAdmin()) {
            $role = 'moderator';
        }
        UserModel::create([
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? 'password123',
            'role' => $role,
            'phone' => trim($_POST['phone'] ?? ''),
        ]);
        $this->redirect('/admin/users', 'User created.');
    }

    public function editForm(string $id): void
    {
        $this->requirePermission('users.update');
        $user = UserModel::findById((int) $id);
        if (!$user) {
            $this->redirect('/admin/users');
        }
        $this->view('admin/users/form', [
            'title' => 'Edit User',
            'layout' => 'admin',
            'user' => $user,
        ]);
    }

    public function update(string $id): void
    {
        $this->requirePermission('users.update');
        UserModel::update((int) $id, [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'role' => $_POST['role'] ?? 'customer',
            'status' => $_POST['status'] ?? 'active',
            'phone' => trim($_POST['phone'] ?? ''),
            'password' => $_POST['password'] ?? '',
        ]);
        $this->redirect('/admin/users', 'User updated.');
    }

    public function delete(string $id): void
    {
        $this->requirePermission('users.delete');
        if ((int) $id === Auth::id()) {
            $this->redirect('/admin/users', 'Cannot delete yourself.');
        }
        UserModel::delete((int) $id);
        $this->redirect('/admin/users', 'User deleted.');
    }
}
