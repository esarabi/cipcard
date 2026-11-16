<?php
declare(strict_types=1);

namespace App\Core;

use RuntimeException;

/**
 * View Renderer with Master Layout Support
 */
class View
{
    private const VIEWS_PATH = __DIR__ . '/../../views/';

    public static function render(string $view, array $data = [], ?string $layout = 'main'): void
    {
        $viewFile = self::VIEWS_PATH . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewFile)) {
            throw new RuntimeException("ویو پیدا نشد: {$viewFile}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        if ($layout !== null) {
            $layoutFile = self::VIEWS_PATH . 'layouts/' . $layout . '.php';
            if (!file_exists($layoutFile)) {
                throw new RuntimeException("قالب Layout پیدا نشد: {$layoutFile}");
            }
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    public static function renderPartial(string $view, array $data = []): string
    {
        $viewFile = self::VIEWS_PATH . str_replace('.', '/', $view) . '.php';
        if (!file_exists($viewFile)) {
            throw new RuntimeException("ویو پارشیال پیدا نشد: {$viewFile}");
        }
        extract($data, EXTR_SKIP);
        ob_start();
        require $viewFile;
        return ob_get_clean();
    }
}
