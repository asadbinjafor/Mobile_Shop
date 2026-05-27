<?php
namespace App\Controllers\Moderator;

use App\Core\Controller;
use App\Models\OrderModel;

class OrderController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('orders.view');
        $this->view('moderator/orders/index', [
            'title' => 'Orders',
            'layout' => 'moderator',
            'orders' => OrderModel::all(),
        ]);
    }

    public function updateStatus(string $id): void
    {
        $this->requirePermission('orders.update_status');
        OrderModel::updateStatus((int) $id, $_POST['status'] ?? 'processing');
        $this->redirect('/moderator/orders', 'Delivery status updated.');
    }
}
