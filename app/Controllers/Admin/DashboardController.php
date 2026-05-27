<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Permission;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class DashboardController extends Controller
{
    public function index(): void
    {
        $orderStats = OrderModel::stats();
        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'layout' => 'admin',
            'orderStats' => $orderStats,
            'productCount' => ProductModel::count(),
            'userCounts' => UserModel::countByRole(),
        ]);
    }
}
