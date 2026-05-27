<?php
namespace App\Core;

class View
{
    public static function render(string $template, array $data = []): void
    {
        $file = ROOT_PATH . '/resources/views/' . str_replace('.', '/', $template) . '.php';
        if (!is_file($file)) {
            http_response_code(500);
            echo 'View not found: ' . e($template);
            return;
        }

        extract($data, EXTR_SKIP);
        $config = App::allConfig();
        $brands = $data['brands'] ?? \App\Models\ProductModel::getBrands();
        $categories = $data['categories'] ?? \App\Models\ProductModel::getCategories();

        if (!empty($layout)) {
            $contentView = $file;
            $layoutFile = ROOT_PATH . '/resources/views/layouts/' . $layout . '.php';
            if (is_file($layoutFile)) {
                require $layoutFile;
                return;
            }
        }

        require $file;
    }

    public static function partial(string $partial, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require ROOT_PATH . '/resources/views/partials/' . $partial . '.php';
    }
}
