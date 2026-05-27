<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Models\OrderModel;

class CheckoutController extends Controller
{
    public function form(): void
    {
        $this->view('customer/checkout', [
            'title' => 'Checkout',
            'user' => Auth::user(),
        ]);
    }

    public function place(): void
    {
        $cart = json_decode($_POST['cart_json'] ?? '[]', true);
        if (!$cart) {
            Session::flash('error', 'Cart is empty.');
            $this->redirect('/');
        }

        $shipping = [
            'name' => trim($_POST['name'] ?? Auth::user()['name']),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
        ];

        try {
            $orderNumber = OrderModel::create(Auth::id(), $cart, $shipping, $_POST['payment'] ?? 'cod');
            Session::flash('success', 'Order placed! Order #' . $orderNumber);
            $this->redirect('/account/orders');
        } catch (\Throwable $e) {
            Session::flash('error', 'Checkout failed: ' . $e->getMessage());
            $this->redirect('/checkout');
        }
    }
}
