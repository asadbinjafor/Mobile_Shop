<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Models\BrandModel;

class BrandController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('settings.view');
        $this->view('admin/brands/index', [
            'title' => 'Brand Management',
            'layout' => 'admin',
            'brands' => BrandModel::all(),
        ]);
    }

    public function createForm(): void
    {
        $this->requirePermission('settings.update');
        $this->view('admin/brands/form', [
            'title' => 'Add Brand',
            'layout' => 'admin',
            'brand' => null,
        ]);
    }

    public function create(): void
    {
        $this->requirePermission('settings.update');
        $data = $this->payload();
        if ($data === null) {
            $this->redirect('/admin/brands');
        }
        if (BrandModel::findBySlug($data['slug'])) {
            Session::flash('error', 'Slug already exists.');
            $this->redirect('/admin/brands/create');
        }
        BrandModel::create($data);
        $this->redirect('/admin/brands', 'Brand created.');
    }

    public function editForm(string $id): void
    {
        $this->requirePermission('settings.update');
        $brand = BrandModel::find((int) $id);
        if (!$brand) {
            $this->redirect('/admin/brands');
        }
        $this->view('admin/brands/form', [
            'title' => 'Edit Brand',
            'layout' => 'admin',
            'brand' => $brand,
        ]);
    }

    public function update(string $id): void
    {
        $this->requirePermission('settings.update');
        $existing = BrandModel::find((int) $id);
        if (!$existing) {
            $this->redirect('/admin/brands');
        }
        $data = $this->payload();
        if ($data === null) {
            $this->redirect('/admin/brands/' . $id . '/edit');
        }
        $dup = BrandModel::findBySlug($data['slug']);
        if ($dup && (int) $dup['id'] !== (int) $id) {
            Session::flash('error', 'Slug already exists.');
            $this->redirect('/admin/brands/' . $id . '/edit');
        }
        BrandModel::update((int) $id, $data);
        $this->redirect('/admin/brands', 'Brand updated.');
    }

    public function delete(string $id): void
    {
        $this->requirePermission('settings.update');
        BrandModel::delete((int) $id);
        $this->redirect('/admin/brands', 'Brand deleted.');
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
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
    }
}

