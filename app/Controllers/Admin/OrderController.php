<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\OrderModel;

class OrderController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('orders.view');
        $this->view('admin/orders/index', [
            'title' => 'All Orders',
            'layout' => 'admin',
            'orders' => OrderModel::all(),
        ]);
    }

    public function show(string $id): void
    {
        $this->requirePermission('orders.view');
        $order = OrderModel::find((int) $id);
        if (!$order) {
            $this->redirect('/admin/orders');
        }
        $this->view('admin/orders/show', [
            'title' => 'Order ' . $order['order_number'],
            'layout' => 'admin',
            'order' => $order,
            'items' => OrderModel::items((int) $id),
        ]);
    }

    public function updateStatus(string $id): void
    {
        $this->requirePermission('orders.update');
        $status = $_POST['status'] ?? 'pending';
        OrderModel::updateStatus((int) $id, $status);
        $this->redirect('/admin/orders/' . $id, 'Order status updated.');
    }

    public function cancel(string $id): void
    {
        $this->requirePermission('orders.cancel');
        OrderModel::updateStatus((int) $id, 'cancelled');
        $this->redirect('/admin/orders', 'Order cancelled.');
    }
}
