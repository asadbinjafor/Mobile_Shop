<?php
namespace App\Models;

use App\Core\Database;

class ProductModel
{
    private static ?array $products = null;

    private static function normalize(array $row): array
    {
        return [
            'id' => (int) $row['id'],
            'name' => $row['name'],
            'brand' => $row['brand'],
            'category' => $row['category'] ?? 'phones',
            'section' => $row['section'] ?? 'deals',
            'price' => (int) $row['price'],
            'oldPrice' => (int) ($row['old_price'] ?? $row['oldPrice'] ?? 0),
            'stock' => (int) ($row['stock'] ?? 50),
            'image' => $row['image'],
            'label' => $row['label'] ?? 'hot',
            'outOfStock' => !empty($row['out_of_stock']) || !empty($row['outOfStock']),
        ];
    }

    private static function fromDb(): ?array
    {
        try {
            $rows = Database::connection()->query('SELECT * FROM products ORDER BY id ASC')->fetchAll();
            return array_map([self::class, 'normalize'], $rows);
        } catch (\Throwable) {
            return null;
        }
    }

    public static function labels(): array
    {
        return [
            'hot' => ['text' => '🔥 Hot Product', 'cls' => 'label-hot'],
            'top' => ['text' => '🛍️ Top Selling', 'cls' => 'label-top'],
            'demand' => ['text' => '👍 High Demand', 'cls' => 'label-demand'],
            'choice' => ['text' => '😍 Customers Choice', 'cls' => 'label-choice'],
            'popular' => ['text' => 'Most Popular', 'cls' => 'label-popular'],
            'best' => ['text' => '🛍️ Best Selling', 'cls' => 'label-top'],
            'discount1' => ['text' => 'Discount ৳ 1', 'cls' => 'label-demand'],
        ];
    }

    private static function allProducts(): array
    {
        if (self::$products === null) {
            self::$products = self::fromDb() ?? require ROOT_PATH . '/data/products.php';
        }
        return self::$products;
    }

    public static function create(array $data): int
    {
        $stmt = Database::connection()->prepare(
            'INSERT INTO products (name, brand, category, section, price, old_price, stock, image, label, out_of_stock)
             VALUES (?,?,?,?,?,?,?,?,?,?)'
        );
        $stmt->execute([
            $data['name'], $data['brand'], $data['category'] ?? 'phones', $data['section'] ?? 'deals',
            $data['price'], $data['old_price'], $data['stock'] ?? 50, $data['image'],
            $data['label'] ?? 'hot', !empty($data['out_of_stock']) ? 1 : 0,
        ]);
        self::$products = null;
        return (int) Database::connection()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        Database::connection()->prepare(
            'UPDATE products SET name=?, brand=?, category=?, section=?, price=?, old_price=?, stock=?, image=?, label=?, out_of_stock=? WHERE id=?'
        )->execute([
            $data['name'], $data['brand'], $data['category'], $data['section'],
            $data['price'], $data['old_price'], $data['stock'], $data['image'],
            $data['label'], !empty($data['out_of_stock']) ? 1 : 0, $id,
        ]);
        self::$products = null;
    }

    public static function delete(int $id): void
    {
        Database::connection()->prepare('DELETE FROM products WHERE id = ?')->execute([$id]);
        self::$products = null;
    }

    public static function count(): int
    {
        try {
            return (int) Database::connection()->query('SELECT COUNT(*) FROM products')->fetchColumn();
        } catch (\Throwable) {
            return count(self::allProducts());
        }
    }

    public static function getAll(): array
    {
        return self::allProducts();
    }

    public static function filter(array $filters = []): array
    {
        $q = trim($filters['q'] ?? '');
        $brand = strtolower(trim($filters['brand'] ?? ''));
        $category = strtolower(trim($filters['category'] ?? ''));

        try {
            $sql = 'SELECT * FROM products WHERE 1=1';
            $params = [];

            if ($q !== '') {
                $sql .= ' AND (name LIKE ? OR brand LIKE ? OR category LIKE ?)';
                $like = '%' . $q . '%';
                array_push($params, $like, $like, $like);
            }
            if ($brand !== '') {
                $sql .= ' AND brand = ?';
                $params[] = $brand;
            }
            if ($category !== '') {
                $sql .= ' AND category = ?';
                $params[] = $category;
            }

            $sql .= ' ORDER BY id DESC';
            $stmt = Database::connection()->prepare($sql);
            $stmt->execute($params);
            return array_map([self::class, 'normalize'], $stmt->fetchAll());
        } catch (\Throwable) {
            $list = self::allProducts();
            if ($q !== '') {
                $list = self::search($q);
            }
            if ($brand !== '') {
                $list = array_values(array_filter($list, fn($p) => $p['brand'] === $brand));
            }
            if ($category !== '') {
                $list = array_values(array_filter($list, fn($p) => ($p['category'] ?? 'phones') === $category));
            }
            usort($list, fn($a, $b) => $b['id'] <=> $a['id']);
            return $list;
        }
    }

    public static function categoryNameMap(): array
    {
        $map = [];
        foreach (self::getCategories() as $c) {
            $map[$c['slug']] = $c['name'];
        }
        try {
            foreach (Database::connection()->query('SELECT slug, name FROM categories')->fetchAll() as $r) {
                $map[$r['slug']] = $r['name'];
            }
        } catch (\Throwable) {
            // ignore
        }
        return $map;
    }

    public static function brandNameMap(): array
    {
        $map = [];
        foreach (self::getBrands() as $b) {
            $map[$b['slug']] = $b['name'];
        }
        try {
            foreach (Database::connection()->query('SELECT slug, name FROM brands')->fetchAll() as $r) {
                $map[$r['slug']] = $r['name'];
            }
        } catch (\Throwable) {
            // ignore
        }
        return $map;
    }

    public static function isValidBrandSlug(string $slug): bool
    {
        $slug = strtolower(trim($slug));
        if ($slug === '') {
            return false;
        }
        try {
            return BrandModel::findBySlug($slug) !== null;
        } catch (\Throwable) {
            foreach (self::getBrands() as $b) {
                if ($b['slug'] === $slug) {
                    return true;
                }
            }
            return false;
        }
    }

    public static function isValidCategorySlug(string $slug): bool
    {
        $slug = strtolower(trim($slug));
        if ($slug === '') {
            return false;
        }
        try {
            return CategoryModel::findBySlug($slug) !== null;
        } catch (\Throwable) {
            foreach (self::getCategories() as $c) {
                if ($c['slug'] === $slug) {
                    return true;
                }
            }
            return false;
        }
    }

    public static function getById(int|string $id): ?array
    {
        $id = (int) $id;
        foreach (self::allProducts() as $p) {
            if ($p['id'] === $id) {
                return $p;
            }
        }
        return null;
    }

    public static function getBySection(string $section): array
    {
        return array_values(array_filter(self::allProducts(), fn($p) => $p['section'] === $section));
    }

    public static function getByBrand(string $brand): array
    {
        $brand = strtolower($brand);
        return array_values(array_filter(self::allProducts(), fn($p) => $p['brand'] === $brand));
    }

    public static function getByCategory(string $category): array
    {
        $category = strtolower($category);
        return array_values(array_filter(
            self::allProducts(),
            fn($p) => ($p['category'] ?? 'phones') === $category
        ));
    }

    public static function search(string $query): array
    {
        $q = strtolower(trim($query));
        if ($q === '') {
            return self::getAll();
        }
        return array_values(array_filter(
            self::allProducts(),
            fn($p) => stripos($p['name'], $q) !== false || stripos($p['brand'], $q) !== false
        ));
    }

    public static function getBrands(): array
    {
        try {
            $rows = Database::connection()
                ->query('SELECT slug, name FROM brands WHERE is_active = 1 ORDER BY sort_order ASC, name ASC')
                ->fetchAll();
            if (!empty($rows)) {
                return array_map(fn($r) => ['slug' => $r['slug'], 'name' => $r['name']], $rows);
            }
        } catch (\Throwable) {
            // fall back to defaults
        }

        return [
            ['slug' => 'samsung', 'name' => 'Samsung'],
            ['slug' => 'apple', 'name' => 'Apple'],
            ['slug' => 'xiaomi', 'name' => 'Xiaomi'],
            ['slug' => 'oppo', 'name' => 'Oppo'],
            ['slug' => 'vivo', 'name' => 'Vivo'],
            ['slug' => 'realme', 'name' => 'Realme'],
            ['slug' => 'oneplus', 'name' => 'OnePlus'],
            ['slug' => 'infinix', 'name' => 'Infinix'],
            ['slug' => 'tecno', 'name' => 'Tecno'],
            ['slug' => 'motorola', 'name' => 'Motorola'],
            ['slug' => 'google', 'name' => 'Google'],
            ['slug' => 'nothing', 'name' => 'Nothing'],
        ];
    }

    public static function getCategories(): array
    {
        try {
            $rows = Database::connection()
                ->query('SELECT slug, name, icon FROM categories WHERE is_active = 1 ORDER BY sort_order ASC, name ASC')
                ->fetchAll();
            if (!empty($rows)) {
                return array_map(
                    fn($r) => ['slug' => $r['slug'], 'name' => $r['name'], 'icon' => $r['icon'] ?: '📦'],
                    $rows
                );
            }
        } catch (\Throwable) {
            // fall back to defaults
        }

        return [
            ['slug' => 'phones', 'name' => 'Phones', 'icon' => '📱'],
            ['slug' => 'tablets', 'name' => 'Tablet', 'icon' => '📲'],
            ['slug' => 'laptops', 'name' => 'Laptop', 'icon' => '💻'],
            ['slug' => 'smartwatch', 'name' => 'Smart Watch', 'icon' => '⌚'],
            ['slug' => 'gadgets', 'name' => 'Gadget', 'icon' => '🎧'],
            ['slug' => 'accessories', 'name' => 'Accessories', 'icon' => '🔌'],
            ['slug' => 'sounds', 'name' => 'Sounds', 'icon' => '🔊'],
            ['slug' => 'smarttv', 'name' => 'Smart TV', 'icon' => '📺'],
        ];
    }

    public static function findCategory(string $slug): ?array
    {
        $slug = strtolower(trim($slug));
        $fromDb = CategoryModel::findPublicBySlug($slug);
        if ($fromDb) {
            return $fromDb;
        }
        foreach (self::getCategories() as $cat) {
            if ($cat['slug'] === $slug) {
                return $cat;
            }
        }
        return null;
    }
}
