<?php
class Router
{
    private array $routes = [];
    private string $basePath;

    public function __construct(string $basePath = '') {
        $this->basePath = rtrim($basePath, '/');
    }

    // Ajouter une route
    public function add(string $method, string $path, string $controller, string $action): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    // Lancer le routeur
    public function dispatch(string $requestMethod, string $requestUri): void
    {
        // Supprimer la base path du projet (ex: "/personne-app/public")
        $uri = str_replace($this->basePath, '', $requestUri);
        // Nettoyer les slashes (ex: /create/ devient /create)
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            // Vérification stricte de l'URL (pour le moment, sans paramètres dynamiques)
            if ($route['path'] === $uri) {
                $controllerName = $route['controller'];
                $actionName = $route['action'];

                // Instancier le contrôleur et appeler la méthode
                require_once __DIR__ . '/../controllers/' . $controllerName . '.php';
                $controller = new $controllerName($GLOBALS['db']); // On passe la DB qu'on a stockée globalement ou via un container
                
                if (method_exists($controller, $actionName)) {
                    $controller->$actionName();
                    return;
                }
            }
        }

        // Si aucune route ne correspond
        http_response_code(404);
        echo "404 - Page non trouvée";
    }
}