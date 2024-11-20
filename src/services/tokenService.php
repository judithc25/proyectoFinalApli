<?php
class TokenService {
    private $secretKey = 'Judi';
    private $expirationTime = 7200;

    public function generarToken($data) {
        $payload = [
            'data' => $data,
            'exp' => time() + $this->expirationTime
        ];
        return JWT::encode($payload, $this->secretKey);
    }

    public function verificarToken($token) {
        try {
            $decored = JWT::decore($token, $this->secretKey, ['HS256']);
            return (array) $decored;
        } catch (Exception $e) {
            return false;
        }
    }
}

?>
