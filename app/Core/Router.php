<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Clean HTTP Router with Middleware Pipeline and Regex Parameter Matching
 */
class Router
{
    private array $routes = [];

    public function get(string $pattern, array $handler, array $middlewares = []): void
    {
        $this->addRoute('GET', $pattern, $handler, $middlewares);
    }

    public function post(string $pattern, array $handler, array $middlewares = []): void
    {
        $this->addRoute('POST', $pattern, $handler, $middlewares);
    }

    private function addRoute(string $method, string $pattern, array $handler, array $middlewares): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'handler' => $handler,
            'middlewares' => $middlewares
        ];
    }

    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $uri = rawurldecode($uri);

        // Remove trailing slash if not root
        if ($uri !== '/' && str_ends_with($uri, '/')) {
            $uri = rtrim($uri, '/');
        }

        // Support .htaccess query parameter fallback (e.g. ?route=profile&mobile=0912...)
        if (isset($_GET['route']) && $_GET['route'] === 'profile' && isset($_GET['mobile'])) {
            $uri = '/@' . $_GET['mobile'];
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            // Convert route pattern {param} to regex
            $patternRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route['pattern']);
            $patternRegex = '#^' . $patternRegex . '$#u';

            if (preg_match($patternRegex, $uri, $matches)) {
                $params = array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY);

                // Run Middlewares
                foreach ($route['middlewares'] as $middlewareClass) {
                    $middleware = new $middlewareClass();
                    $middleware->handle();
                }

                [$controllerClass, $actionMethod] = $route['handler'];
                $controller = new $controllerClass();
                call_user_func_array([$controller, $actionMethod], $params);
                return;
            }
        }

        // 404 Not Found
        http_response_code(404);
        View::render('home.404', ['title' => 'صفحه پیدا نشد - CIPCard'], 'main');
    }
}
