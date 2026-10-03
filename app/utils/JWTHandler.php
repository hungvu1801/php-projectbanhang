<?php

require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class JWTHandler
{
    private $secret_key;

    public function __construct()
    {
        $this->secret_key = "f7a9922948df1d114fcb83377a59c8b90dd0d4b977ace5512a76fef79bd29459";
    }

    public function encode($data)
    {
        $issueAt = time();
        $expirationTimee = $issueAt + 3600; // valid 1 hour
        $payload = array(
            'iat' => $issueAt,
            'exp' => $expirationTimee,
            'data' => $data
        );

        return JWT::encode($payload, $this->secret_key,'HS256');
    }

    public function decode($jwt)
    {
        try {
            $decode = JWT::decode($jwt, new Key($this->secret_key, 'HS256'));
            return (array) $decode->data;
        } catch( Exception $e) {
            return null;
        }
    }
}