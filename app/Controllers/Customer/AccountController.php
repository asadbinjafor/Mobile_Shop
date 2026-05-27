<?php
namespace App\Controllers\Customer;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Models\UserModel;

class AccountController extends Controller
{
    public function index(): void
    {
        $this->view('customer/account', [
            'title' => 'My Account',
            'layout' => 'customer',
            'user' => Auth::user(),
        ]);
    }

    public function update(): void
    {
        UserModel::update(Auth::id(), [
            'name' => trim($_POST['name'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'password' => $_POST['password'] ?? '',
        ]);
        $user = UserModel::findById(Auth::id());
        Auth::login($user);
        Session::flash('success', 'Profile updated.');
        $this->redirect('/account');
    }
}
