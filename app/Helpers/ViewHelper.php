<?php
namespace App\Helpers;

use App\Models\ProductModel;

class ViewHelper
{
    public static function formatPrice(int|float $amount): string
    {
        return '৳ ' . number_format((float) $amount);
    }

    public static function getDiscount(int|float $price, int|float $oldPrice): int
    {
        if ($oldPrice <= 0) {
            return 0;
        }
        return (int) round((($oldPrice - $price) / $oldPrice) * 100);
    }

    public static function enrichProduct(array $product): array
    {
        $labels = ProductModel::labels();
        $label = $labels[$product['label'] ?? 'hot'] ?? $labels['hot'];
        $discount = self::getDiscount($product['price'], $product['oldPrice']);

        $id = (int) ($product['id'] ?? 0);

        return array_merge($product, [
            'discount' => $discount,
            'labelText' => $label['text'],
            'labelClass' => $label['cls'],
            'hasEmi' => $product['price'] >= 10000,
            'formattedPrice' => self::formatPrice($product['price']),
            'formattedOldPrice' => self::formatPrice($product['oldPrice']),
            'outOfStock' => !empty($product['outOfStock']),
            'rating' => round(4.0 + ($id % 10) / 10, 1),
            'reviewCount' => 15 + ($id * 13) % 350,
            'inStock' => empty($product['outOfStock']),
        ]);
    }

    public static function enrichMany(array $products): array
    {
        return array_map([self::class, 'enrichProduct'], $products);
    }
}
