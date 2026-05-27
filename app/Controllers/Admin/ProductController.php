<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\ProductModel;

class ProductController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('products.view');
        $this->view('admin/products/index', [
            'title' => 'Products',
            'layout' => 'admin',
            'products' => ProductModel::getAll(),
        ]);
    }

    public function createForm(): void
    {
        $this->requirePermission('products.create');
        $this->view('admin/products/form', [
            'title' => 'Add Product',
            'layout' => 'admin',
            'product' => null,
        ]);
    }

    public function create(): void
    {
        $this->requirePermission('products.create');
        ProductModel::create($this->payload());
        $this->redirect('/admin/products', 'Product added.');
    }

    public function editForm(string $id): void
    {
        $this->requirePermission('products.update');
        $p = ProductModel::getById($id);
        if (!$p) {
            $this->redirect('/admin/products');
        }
        $this->view('admin/products/form', [
            'title' => 'Edit Product',
            'layout' => 'admin',
            'product' => $p,
        ]);
    }

    public function update(string $id): void
    {
        $this->requirePermission('products.update');
        ProductModel::update((int) $id, $this->payload());
        $this->redirect('/admin/products', 'Product updated.');
    }

    public function delete(string $id): void
    {
        $this->requirePermission('products.delete');
        ProductModel::delete((int) $id);
        $this->redirect('/admin/products', 'Product deleted.');
    }

    private function payload(): array
    {
        return [
            'name' => trim($_POST['name'] ?? ''),
            'brand' => strtolower(trim($_POST['brand'] ?? '')),
            'category' => $_POST['category'] ?? 'phones',
            'section' => $_POST['section'] ?? 'deals',
            'price' => (int) ($_POST['price'] ?? 0),
            'old_price' => (int) ($_POST['old_price'] ?? 0),
            'stock' => (int) ($_POST['stock'] ?? 0),
            'image' => trim($_POST['image'] ?? ''),
            'label' => $_POST['label'] ?? 'hot',
            'out_of_stock' => isset($_POST['out_of_stock']) ? 1 : 0,
        ];
    }
}
