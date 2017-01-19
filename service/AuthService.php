<?php

class AuthService
{

    static $instance = null;
    protected $conn = null;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new AuthService();
        }

        return self::$instance;
    }

    public static function generateToken($id, $username, $password)
    {
        return base64_encode($id . '-' . $username . '-' . md5($password));
    }

    public static function validToken($token)
    {
        // TODO check if $token is valid

        return !empty($token);
    }

    public static function getUserIdFromToken($token)
    {
        $token = base64_decode($token);
        $token = explode('-', $token);

        return intval($token[0]);
    }

}
