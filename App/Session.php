<?php

namespace App;

class Session
{
    public static array $session = [];
    public function __construct()
    {
        session_start();
        self::$session = $_SESSION;
    }

    public static function has($key) : bool
    {
        return in_array($key, self::$session);
    }

    public static function get($key) : mixed
    {
        return self::has($key) ? self::$session[$key] : null;
    }

    public static function put($key, $value) : void
    {
        $_SESSION[$key] = $value;
    }

    public static function pull(string|array $key) : void
    {
        $keys = is_array($key) ? $key : [$key];

        foreach ($keys as $key) {
            if (self::has($key)) { unset($_SESSION[$key]); };
        }
    }
}