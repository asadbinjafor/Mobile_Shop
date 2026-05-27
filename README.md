# MobileHub BD — Mobile Shop Website

Dazzle-style mobile shop — **PHP MVC (XAMPP)** + Node.js MVC (optional).

## XAMPP দিয়ে চালান (প্রস্তাবিত)

বিস্তারিত: **[XAMPP-SETUP.md](XAMPP-SETUP.md)**

1. XAMPP ইনস্টল → Apache Start
2. প্রজেক্ট কপি: `C:\xampp\htdocs\mobilehub`
3. ব্রাউজার: **http://localhost/mobilehub/public/**

## PHP MVC Structure

```
app/Controllers/   → HomeController, ProductController
app/Models/        → ProductModel
app/Core/          → Router, View
resources/views/   → PHP templates
public/index.php   → Front controller
routes/web.php     → Routes
data/products.php  → Product data
```

## Node.js (ঐচ্ছিক)

```bash
npm install
npm start
# http://localhost:3000
```

## Customize

| কী | ফাইল |
|-----|------|
| Phone, email | `config/config.php` |
| Products | `data/products.php` |
