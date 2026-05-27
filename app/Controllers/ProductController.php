<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\ViewHelper;
use App\Models\ProductModel;

class ProductController extends Controller
{
    public function index(): void
    {
        $q = trim($_GET['q'] ?? '');
        $brand = strtolower(trim($_GET['brand'] ?? ''));
        $category = strtolower(trim($_GET['category'] ?? ''));
        $minPrice = (int) ($_GET['min_price'] ?? 0);
        $maxPrice = (int) ($_GET['max_price'] ?? 0);
        $sort = $_GET['sort'] ?? 'newest';

        if ($brand !== '' && !ProductModel::isValidBrandSlug($brand)) {
            $brand = '';
        }
        $activeCategories = array_column(ProductModel::getCategories(), 'slug');
        if ($category !== '' && !in_array($category, $activeCategories, true)) {
            $category = '';
        }

        $list = $q !== '' ? ProductModel::search($q) : ProductModel::getAll();

        if ($brand !== '') {
            $list = array_values(array_filter($list, fn($p) => $p['brand'] === strtolower($brand)));
        }
        if ($category !== '') {
            $list = array_values(array_filter($list, fn($p) => ($p['category'] ?? 'phones') === strtolower($category)));
        }
        if ($minPrice > 0) {
            $list = array_values(array_filter($list, fn($p) => $p['price'] >= $minPrice));
        }
        if ($maxPrice > 0) {
            $list = array_values(array_filter($list, fn($p) => $p['price'] <= $maxPrice));
        }

        $list = $this->sortProducts($list, $sort);

        $title = $q !== '' ? "Search: $q" : ($brand !== '' ? ucfirst($brand) . ' Products' : 'All Products');

        $this->view('products/index', [
            'title' => $title,
            'products' => ViewHelper::enrichMany($list),
            'query' => $q,
            'brand' => $brand,
            'category' => $category,
            'sort' => $sort,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'brands' => ProductModel::getBrands(),
            'categories' => ProductModel::getCategories(),
        ]);
    }

    private function sortProducts(array $list, string $sort): array
    {
        usort($list, function ($a, $b) use ($sort) {
            return match ($sort) {
                'price_low' => $a['price'] <=> $b['price'],
                'price_high' => $b['price'] <=> $a['price'],
                'name' => strcmp($a['name'], $b['name']),
                default => $b['id'] <=> $a['id'],
            };
        });
        return $list;
    }

    public function show(string $id): void
    {
        $product = ProductModel::getById($id);
        if (!$product) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Product Not Found']);
            return;
        }

        $related = array_slice(
            array_filter(ProductModel::getByBrand($product['brand']), fn($p) => $p['id'] !== $product['id']),
            0,
            4
        );

        $this->view('products/show', [
            'title' => $product['name'],
            'product' => ViewHelper::enrichProduct($product),
            'related' => ViewHelper::enrichMany($related),
        ]);
    }

    public function category(string $slug): void
    {
        $category = ProductModel::findCategory($slug);
        if (!$category) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Category Not Found']);
            return;
        }

        $this->view('products/category', [
            'title' => $category['name'],
            'category' => $category,
            'products' => ViewHelper::enrichMany(ProductModel::getByCategory($slug)),
            'brands' => ProductModel::getBrands(),
            'categories' => ProductModel::getCategories(),
        ]);
    }

    public function apiShow(string $id): void
    {
        $product = ProductModel::getById($id);
        if (!$product) {
            $this->json(['error' => 'Not found'], 404);
        }
        $this->json(ViewHelper::enrichProduct($product));
    }

    public function apiSearch(): void
    {
        $q = trim($_GET['q'] ?? '');
        if (strlen($q) < 2) {
            $this->json([]);
        }
        $results = array_slice(ViewHelper::enrichMany(ProductModel::search($q)), 0, 8);
        $this->json($results);
    }
}
