<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Database;
use App\Core\Permission;
use App\Core\Session;
use App\Models\UserModel;

class AuthController extends Controller
{
    public function loginForm(): void
    {
        if (Auth::check()) {
            $this->redirect(Permission::dashboardUrl());
        }
        $this->view('auth/login', ['title' => 'Login']);
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!Database::isReady()) {
            Session::flash('error', 'Database not installed. Run installer first.');
            $this->redirect('/install');
        }

        if (Auth::attempt($email, $password)) {
            Session::flash('success', 'Welcome back, ' . Auth::user()['name'] . '!');
            $this->redirect(Permission::dashboardUrl());
        }

        Session::flash('error', 'Invalid email or password.');
        $this->redirect('/login');
    }

    public function registerForm(): void
    {
        if (Auth::check()) {
            $this->redirect(Permission::dashboardUrl());
        }
        $this->view('auth/register', ['title' => 'Sign Up']);
    }

    public function register(): void
    {
        if (Auth::check()) {
            $this->redirect(Permission::dashboardUrl());
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['password_confirm'] ?? '';
        $phone = trim($_POST['phone'] ?? '');

        // Registration is CUSTOMER ONLY — ignore any role manipulation
        $role = 'customer';
        if (isset($_POST['role']) && $_POST['role'] !== 'customer') {
            Session::flash('error', 'Registration is only available for customers. Staff accounts are created by admin.');
            $this->redirect('/register');
        }

        if (strlen($name) < 2) {
            Session::flash('error', 'Please enter your full name (at least 2 characters).');
            $this->redirect('/register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', 'Please enter a valid email address.');
            $this->redirect('/register');
        }

        if (strlen($password) < 6) {
            Session::flash('error', 'Password must be at least 6 characters.');
            $this->redirect('/register');
        }

        if ($password !== $confirm) {
            Session::flash('error', 'Password and confirm password do not match.');
            $this->redirect('/register');
        }

        if (!empty($phone) && !preg_match('/^01[0-9]{9}$/', $phone)) {
            Session::flash('error', 'Please enter a valid Bangladesh mobile number (01XXXXXXXXX).');
            $this->redirect('/register');
        }

        if (empty($_POST['terms'])) {
            Session::flash('error', 'You must agree to Terms & Conditions.');
            $this->redirect('/register');
        }

        if (UserModel::findByEmail($email)) {
            Session::flash('error', 'This email is already registered. Please login instead.');
            $this->redirect('/register');
        }

        UserModel::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'phone' => $phone ?: null,
            'status' => 'active',
        ]);

        Auth::attempt($email, $password);
        Session::flash('success', 'Welcome! Your customer account has been created.');
        $this->redirect('/account');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/', 'Logged out successfully.');
    }

    public function forgotForm(): void
    {
        if (Auth::check()) {
            $this->redirect(Permission::dashboardUrl());
        }
        $this->view('auth/forgot', ['title' => 'Forgot Password']);
    }

    public function forgot(): void
    {
        Session::flash('success', 'If this email is registered, you will receive reset instructions shortly.');
        $this->redirect('/login');
    }
}
