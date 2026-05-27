<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class ProductController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('products.view');

        $filters = [
            'q' => trim($_GET['q'] ?? ''),
            'brand' => trim($_GET['brand'] ?? ''),
            'category' => trim($_GET['category'] ?? ''),
        ];

        $this->view('admin/products/index', [
            'title' => 'Products',
            'layout' => 'admin',
            'products' => ProductModel::filter($filters),
            'filters' => $filters,
            'brands' => BrandModel::all(),
            'categories' => CategoryModel::all(),
            'brandNames' => ProductModel::brandNameMap(),
            'categoryNames' => ProductModel::categoryNameMap(),
        ]);
    }

    public function createForm(): void
    {
        $this->requirePermission('products.create');
        $this->view('admin/products/form', [
            'title' => 'Add Product',
            'layout' => 'admin',
            'product' => null,
            'brands' => BrandModel::all(),
            'categories' => CategoryModel::all(),
        ]);
    }

    public function create(): void
    {
        $this->requirePermission('products.create');
        $data = $this->payload();
        if ($data === null) {
            $this->redirect('/admin/products/create');
        }
        ProductModel::create($data);
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
            'brands' => BrandModel::all(),
            'categories' => CategoryModel::all(),
        ]);
    }

    public function update(string $id): void
    {
        $this->requirePermission('products.update');
        $data = $this->payload();
        if ($data === null) {
            $this->redirect('/admin/products/' . $id . '/edit');
        }
        ProductModel::update((int) $id, $data);
        $this->redirect('/admin/products', 'Product updated.');
    }

    public function delete(string $id): void
    {
        $this->requirePermission('products.delete');
        ProductModel::delete((int) $id);
        $this->redirect('/admin/products', 'Product deleted.');
    }

    private function payload(): ?array
    {
        $name = trim($_POST['name'] ?? '');
        $brand = strtolower(trim($_POST['brand'] ?? ''));
        $category = strtolower(trim($_POST['category'] ?? 'phones'));

        if ($name === '') {
            Session::flash('error', 'Product name is required.');
            return null;
        }
        if (!ProductModel::isValidBrandSlug($brand)) {
            Session::flash('error', 'Please select a valid brand.');
            return null;
        }
        if (!ProductModel::isValidCategorySlug($category)) {
            Session::flash('error', 'Please select a valid category.');
            return null;
        }

        return [
            'name' => $name,
            'brand' => $brand,
            'category' => $category,
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
