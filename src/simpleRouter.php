<?php
class SimpleRouter {
    private $routes = [];

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function put($path, $callback) {
        $this->routes['PUT'][$path] = $callback;
    }

    public function delete($path, $callback) {
        $this->routes['DELETE'][$path] = $callback;
    }

    public function dispach() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER ['REQUEST_URI'], PHP_URL_PATH);

        $requestUri = str_replace('/bibliotecadigital3/src/index.php', '', $requestUri);

        foreach ($this->routes[$requestMethod] as $path => $callback) {
            if($requestUri == $path) {
                echo call_user_func($callback());
                return;
            }

        }
            http_response_code(404);
            echo json_encode(['message' => 'Noot found']);
        
    }
}

?>