<?php
use App\Controllers\AuthController;
use App\Controllers\CartPageController;
use App\Controllers\CheckoutController;
use App\Controllers\HomeController;
use App\Controllers\PageController;
use App\Controllers\InstallController;
use App\Controllers\ProductController;
use App\Controllers\Admin\DashboardController as AdminDashboard;
use App\Controllers\Admin\UserController as AdminUser;
use App\Controllers\Admin\ProductController as AdminProduct;
use App\Controllers\Admin\OrderController as AdminOrder;
use App\Controllers\Admin\SettingsController as AdminSettings;
use App\Controllers\Admin\CategoryController as AdminCategory;
use App\Controllers\Admin\BrandController as AdminBrand;
use App\Controllers\Moderator\DashboardController as ModDashboard;
use App\Controllers\Moderator\OrderController as ModOrder;
use App\Controllers\Customer\AccountController;
use App\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Controllers\Customer\OrderController as CustomerOrder;
use App\Core\Router;

$router = new Router();

// Public shop
$router->get('/', [HomeController::class, 'index']);
$router->get('/products', [ProductController::class, 'index']);
$router->get('/products/{id}', [ProductController::class, 'show']);
$router->get('/category/{slug}', [ProductController::class, 'category']);
$router->get('/api/products/{id}', [ProductController::class, 'apiShow']);
$router->get('/api/search', [ProductController::class, 'apiSearch']);

$router->get('/cart', [CartPageController::class, 'index']);
$router->get('/contact', [PageController::class, 'contact']);
$router->get('/about', [PageController::class, 'about']);
$router->get('/faq', [PageController::class, 'faq']);

// Install
$router->get('/install', [InstallController::class, 'index']);
$router->post('/install', [InstallController::class, 'run']);

// Auth
$router->get('/login', [AuthController::class, 'loginForm'], ['guest']);
$router->post('/login', [AuthController::class, 'login'], ['guest']);
$router->get('/register', [AuthController::class, 'registerForm'], ['guest']);
$router->post('/register', [AuthController::class, 'register'], ['guest']);
$router->get('/logout', [AuthController::class, 'logout'], ['auth']);
$router->get('/forgot-password', [AuthController::class, 'forgotForm'], ['guest']);
$router->post('/forgot-password', [AuthController::class, 'forgot']);

// Customer
$router->get('/account', [CustomerDashboard::class, 'index'], ['auth', 'role:customer']);
$router->get('/account/profile', [AccountController::class, 'index'], ['auth', 'role:customer,admin,moderator']);
$router->get('/account/wishlist', [CustomerDashboard::class, 'wishlist'], ['auth', 'role:customer']);
$router->post('/account', [AccountController::class, 'update'], ['auth']);
$router->get('/account/orders', [CustomerOrder::class, 'index'], ['auth', 'role:customer']);
$router->get('/account/orders/{id}', [CustomerOrder::class, 'show'], ['auth', 'role:customer']);
$router->post('/account/orders/{id}/cancel', [CustomerOrder::class, 'cancel'], ['auth', 'role:customer']);
$router->get('/checkout', [CheckoutController::class, 'form'], ['auth', 'role:customer']);
$router->post('/checkout', [CheckoutController::class, 'place'], ['auth', 'role:customer']);

// Admin
$router->get('/admin', [AdminDashboard::class, 'index'], ['auth', 'role:admin']);
$router->get('/admin/users', [AdminUser::class, 'index'], ['auth', 'role:admin']);
$router->get('/admin/users/create', [AdminUser::class, 'createForm'], ['auth', 'role:admin']);
$router->post('/admin/users', [AdminUser::class, 'create'], ['auth', 'role:admin']);
$router->get('/admin/users/{id}/edit', [AdminUser::class, 'editForm'], ['auth', 'role:admin']);
$router->post('/admin/users/{id}', [AdminUser::class, 'update'], ['auth', 'role:admin']);
$router->post('/admin/users/{id}/delete', [AdminUser::class, 'delete'], ['auth', 'role:admin']);
$router->get('/admin/products', [AdminProduct::class, 'index'], ['auth', 'role:admin,moderator']);
$router->get('/admin/products/create', [AdminProduct::class, 'createForm'], ['auth', 'role:admin,moderator']);
$router->post('/admin/products', [AdminProduct::class, 'create'], ['auth', 'role:admin,moderator']);
$router->get('/admin/products/{id}/edit', [AdminProduct::class, 'editForm'], ['auth', 'role:admin,moderator']);
$router->post('/admin/products/{id}', [AdminProduct::class, 'update'], ['auth', 'role:admin,moderator']);
$router->post('/admin/products/{id}/delete', [AdminProduct::class, 'delete'], ['auth', 'role:admin']);
$router->get('/admin/orders', [AdminOrder::class, 'index'], ['auth', 'role:admin,moderator']);
$router->get('/admin/orders/{id}', [AdminOrder::class, 'show'], ['auth', 'role:admin,moderator']);
$router->post('/admin/orders/{id}/status', [AdminOrder::class, 'updateStatus'], ['auth', 'role:admin,moderator']);
$router->post('/admin/orders/{id}/cancel', [AdminOrder::class, 'cancel'], ['auth', 'role:admin']);
$router->get('/admin/settings', [AdminSettings::class, 'index'], ['auth', 'role:admin']);
$router->post('/admin/settings', [AdminSettings::class, 'save'], ['auth', 'role:admin']);

$router->get('/admin/categories', [AdminCategory::class, 'index'], ['auth', 'role:admin']);
$router->get('/admin/categories/create', [AdminCategory::class, 'createForm'], ['auth', 'role:admin']);
$router->post('/admin/categories', [AdminCategory::class, 'create'], ['auth', 'role:admin']);
$router->get('/admin/categories/{id}/edit', [AdminCategory::class, 'editForm'], ['auth', 'role:admin']);
$router->post('/admin/categories/{id}', [AdminCategory::class, 'update'], ['auth', 'role:admin']);
$router->post('/admin/categories/{id}/delete', [AdminCategory::class, 'delete'], ['auth', 'role:admin']);

$router->get('/admin/brands', [AdminBrand::class, 'index'], ['auth', 'role:admin']);
$router->get('/admin/brands/create', [AdminBrand::class, 'createForm'], ['auth', 'role:admin']);
$router->post('/admin/brands', [AdminBrand::class, 'create'], ['auth', 'role:admin']);
$router->get('/admin/brands/{id}/edit', [AdminBrand::class, 'editForm'], ['auth', 'role:admin']);
$router->post('/admin/brands/{id}', [AdminBrand::class, 'update'], ['auth', 'role:admin']);
$router->post('/admin/brands/{id}/delete', [AdminBrand::class, 'delete'], ['auth', 'role:admin']);

// Moderator panel
$router->get('/moderator', [ModDashboard::class, 'index'], ['auth', 'role:moderator,admin']);
$router->get('/moderator/orders', [ModOrder::class, 'index'], ['auth', 'role:moderator,admin']);

return $router;
