<?php
require_once BASE_PATH . '/services/tokenService.php';


class AuthMiddleware {
    public static function verificarToken() {
        $headers = apache_request_headers();
        if(!isset($headers['Authorization'])) {
            return ['mensaje' => 'Token no proporcionado', 'codigo' => 401];
        }
        $token = str_replace('Bearer ', '', $headers['Authorization']);
        $tokenService = new TokenService();
        if(!tokenService->verificarToken($token)){
            return ['mensaje' => 'Token inavalido', 'codigo' => 403];
        }
        return ['mensaje' => 'Token valido', 'codigo' => 200];
    }
}

?>