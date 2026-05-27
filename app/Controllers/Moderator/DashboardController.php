<?php
namespace App\Controllers\Moderator;

use App\Core\Controller;
use App\Models\OrderModel;
use App\Models\ProductModel;

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->view('moderator/dashboard', [
            'title' => 'Moderator Dashboard',
            'layout' => 'moderator',
            'productCount' => ProductModel::count(),
            'pendingOrders' => OrderModel::stats()['pending'] ?? 0,
        ]);
    }
}
