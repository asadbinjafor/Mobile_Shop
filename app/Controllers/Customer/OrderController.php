<?php
namespace App\Controllers\Customer;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\OrderModel;

class OrderController extends Controller
{
    public function index(): void
    {
        $this->view('customer/orders', [
            'title' => 'My Orders',
            'layout' => 'customer',
            'orders' => OrderModel::byUser(Auth::id()),
        ]);
    }

    public function show(string $id): void
    {
        $order = OrderModel::find((int) $id);
        if (!$order || (int) $order['user_id'] !== Auth::id()) {
            $this->redirect('/account/orders');
        }
        $this->view('customer/order-show', [
            'title' => 'Order ' . $order['order_number'],
            'layout' => 'customer',
            'order' => $order,
            'items' => OrderModel::items((int) $id),
        ]);
    }

    public function cancel(string $id): void
    {
        $order = OrderModel::find((int) $id);
        if ($order && (int) $order['user_id'] === Auth::id() && $order['status'] === 'pending') {
            OrderModel::updateStatus((int) $id, 'cancelled');
        }
        $this->redirect('/account/orders', 'Order cancelled.');
    }
}
