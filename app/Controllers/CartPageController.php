<?php
namespace App\Controllers;

use App\Core\Controller;

class CartPageController extends Controller
{
    public function index(): void
    {
        $this->view('cart/index', ['title' => 'Shopping Cart']);
    }
}
