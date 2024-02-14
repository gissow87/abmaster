<?php

use Firebase\JWT\JWT;

class JwtHandler
{
    private static $secret_key = SECRET_KEY;
    private static $algo = ALGORITHM;

    public static function encode($data)
    {
        $token = array(
            'iss' => ISSUER,
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + 60 * 60,  // Token expira en 1 hora
            'data' => $data,
        );

        return JWT::encode($token, self::$secret_key, self::$algo);
    }

    public static function decode($token)
    {
        return JWT::decode($token, self::$secret_key, array(self::$algo));
    }
}
