<?php

define('IV_SIZE', mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

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

    public static function generateToken($id, $username)
    {
        $time = time();
        return self::encrypt(($id . '-' . $username . '-' . $time));
    }

    /**
     * Decrypt token and return info from it
     * @param $token
     * @return array
     */
    public static function getInfoFromToken($token)
    {
        $token = self::decrypt($token);
        $token = explode('-', $token);

        return array(
            'id' => $token[0],
            'username' => $token[1],
            'time' => $token[2]
        );
    }

    public static function isTokenValid($token)
    {
        $time = self::getInfoFromToken($token)['time'];

        return abs(time() - $time) < ConfigService::getEnv('token_expire_time');
    }

    public static function getUserIdFromToken($token)
    {
        $token = self::decrypt($token);
        $token = explode('-', $token);

        return intval($token[0]);
    }

    /**
     * Encrypt $payload and return it
     * @param $payload
     * @return string
     */
    public static function encrypt($payload)
    {
        $key = ConfigService::getEnv('secret_key');
        $iv = mcrypt_create_iv(IV_SIZE, MCRYPT_DEV_URANDOM);
        $crypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $payload, MCRYPT_MODE_CBC, $iv);
        $combo = $iv . $crypt;
        $garble = base64_encode($combo);
        return $garble;
    }

    /**
     * Decrypt payload and return original message
     * @param $garble
     * @return string
     */
    public static function decrypt($garble)
    {
        $key = ConfigService::getEnv('secret_key');
        $combo = base64_decode($garble);
        $iv = substr($combo, 0, IV_SIZE);
        $crypt = substr($combo, IV_SIZE, strlen($combo));
        $payload = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $crypt, MCRYPT_MODE_CBC, $iv);
        return $payload;
    }


}