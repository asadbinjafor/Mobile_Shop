<?php
namespace App\Controllers\Customer;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\OrderModel;

class DashboardController extends Controller
{
    public function index(): void
    {
        $orders = Auth::isCustomer() ? OrderModel::byUser(Auth::id()) : [];
        $this->view('customer/dashboard', [
            'title' => 'My Dashboard',
            'orders' => $orders,
            'orderCount' => count($orders),
        ]);
    }

    public function wishlist(): void
    {
        $this->view('customer/wishlist', ['title' => 'My Wishlist']);
    }
}
