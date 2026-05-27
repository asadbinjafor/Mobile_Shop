<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\ViewHelper;
use App\Models\ProductModel;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/index', [
            'title' => 'Best Mobile, Laptop & Gadget Shop in Bangladesh',
            'flashProducts' => ViewHelper::enrichMany(ProductModel::getBySection('flash')),
            'dealProducts' => ViewHelper::enrichMany(ProductModel::getBySection('deals')),
            'recentProducts' => ViewHelper::enrichMany(ProductModel::getBySection('recent')),
            'trendingProducts' => ViewHelper::enrichMany(ProductModel::getBySection('trending')),
            'brands' => ProductModel::getBrands(),
            'categories' => ProductModel::getCategories(),
        ]);
    }
}
