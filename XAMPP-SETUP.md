# MobileHub BD — PHP MVC (XAMPP)

Laravel-style **MVC** structure — XAMPP এ সরাসরি চলবে (Node.js লাগবে না)।

## MVC Structure

```
app/
  Controllers/     ← Logic (HomeController, ProductController)
  Models/          ← Data (ProductModel)
  Core/            ← Router, View, App
  Helpers/         ← ViewHelper, functions
config/            ← Site settings
data/              ← products.php
routes/web.php     ← URLs
resources/views/   ← HTML templates (View)
public/            ← index.php, CSS, JS (Apache entry)
```

## XAMPP ইনস্টল (একবার)

1. ডাউনলোড: https://www.apachefriends.org/
2. ইনস্টল করুন
3. **XAMPP Control Panel** → Apache **Start**

## প্রজেক্ট সেটআপ

### পদ্ধতি ১ — htdocs এ কপি (সহজ)

1. পুরো ফোল্ডার কপি করুন:
   ```
   C:\xampp\htdocs\mobilehub
   ```
2. ব্রাউজারে খুলুন:
   ```
   http://localhost/mobilehub/public/
   ```

### পদ্ধতি ২ — বর্তমান ফোল্ডার থেকে

যদি প্রজেক্ট ইতিমধ্যে `Downloads\New folder (2)` এ থাকে:

1. XAMPP Apache চালু করুন
2. Virtual host না দিলে, ফোল্ডার `htdocs\mobilehub` এ কপি করুন
3. URL: `http://localhost/mobilehub/public/`

## URLs

| Page | URL |
|------|-----|
| Home | `http://localhost/mobilehub/public/` |
| Products | `http://localhost/mobilehub/public/products` |
| Product | `http://localhost/mobilehub/public/products/1` |
| Category | `http://localhost/mobilehub/public/category/phones` |
| Search | `http://localhost/mobilehub/public/products?q=samsung` |

## Customize

- **দোকানের তথ্য:** `config/config.php`
- **প্রোডাক্ট:** `data/products.php`

## সমস্যা সমাধান

### 404 on every page
- `public/.htaccess` আছে কিনা দেখুন
- XAMPP → Apache **Config** → `httpd.conf` এ `mod_rewrite` enable আছে কিনা
- `AllowOverride All` আছে কিনা (`htdocs` এর জন্য)

### CSS/JS load হয় না
- URL অবশ্যই `/public/` দিয়ে শেষ হোক
- অথবা DocumentRoot সরাসরি `public` ফোল্ডারে সেট করুন

### PHP version
- PHP 7.4+ বা 8.x প্রয়োজন (XAMPP এ সাধারণত থাকে)

## Node.js vs PHP

| | Node (`npm start`) | PHP (XAMPP) |
|--|-------------------|-------------|
| চালান | `npm install` + `npm start` | Apache Start |
| URL | localhost:3000 | localhost/mobilehub/public |

**XAMPP ব্যবহার করুন** — আপনার জন্য PHP MVC তৈরি করা হয়েছে।
