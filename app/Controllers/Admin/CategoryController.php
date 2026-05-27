<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Models\CategoryModel;

class CategoryController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('settings.view');
        $this->view('admin/categories/index', [
            'title' => 'Category Management',
            'layout' => 'admin',
            'categories' => CategoryModel::all(),
        ]);
    }

    public function createForm(): void
    {
        $this->requirePermission('settings.update');
        $this->view('admin/categories/form', [
            'title' => 'Add Category',
            'layout' => 'admin',
            'category' => null,
        ]);
    }

    public function create(): void
    {
        $this->requirePermission('settings.update');
        $data = $this->payload();
        if ($data === null) {
            $this->redirect('/admin/categories');
        }
        if (CategoryModel::findBySlug($data['slug'])) {
            Session::flash('error', 'Slug already exists.');
            $this->redirect('/admin/categories/create');
        }
        CategoryModel::create($data);
        $this->redirect('/admin/categories', 'Category created.');
    }

    public function editForm(string $id): void
    {
        $this->requirePermission('settings.update');
        $cat = CategoryModel::find((int) $id);
        if (!$cat) {
            $this->redirect('/admin/categories');
        }
        $this->view('admin/categories/form', [
            'title' => 'Edit Category',
            'layout' => 'admin',
            'category' => $cat,
        ]);
    }

    public function update(string $id): void
    {
        $this->requirePermission('settings.update');
        $existing = CategoryModel::find((int) $id);
        if (!$existing) {
            $this->redirect('/admin/categories');
        }
        $data = $this->payload();
        if ($data === null) {
            $this->redirect('/admin/categories/' . $id . '/edit');
        }
        $dup = CategoryModel::findBySlug($data['slug']);
        if ($dup && (int) $dup['id'] !== (int) $id) {
            Session::flash('error', 'Slug already exists.');
            $this->redirect('/admin/categories/' . $id . '/edit');
        }
        CategoryModel::update((int) $id, $data);
        $this->redirect('/admin/categories', 'Category updated.');
    }

    public function delete(string $id): void
    {
        $this->requirePermission('settings.update');
        CategoryModel::delete((int) $id);
        $this->redirect('/admin/categories', 'Category deleted.');
    }

    private function payload(): ?array
    {
        $slug = strtolower(trim($_POST['slug'] ?? ''));
        $name = trim($_POST['name'] ?? '');
        if ($slug === '' || $name === '') {
            Session::flash('error', 'Slug and Name are required.');
            return null;
        }
        if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
            Session::flash('error', 'Slug must be lowercase letters, numbers, and hyphen only.');
            return null;
        }
        return [
            'slug' => $slug,
            'name' => $name,
            'icon' => trim($_POST['icon'] ?? ''),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
    }
}

