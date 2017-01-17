<?php

class SessionService
{
    /**
     * Set session value
     * @param $name
     * @param $value
     */
    public static function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     *
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public static function get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        throw new Exception("Variable $name not found in session");
    }

    /**
     * Unset session
     * @param $name
     */
    public static function unset($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * Logout - destroy all sessions
     */
    public static function destroy()
    {
        session_destroy();
        session_start();
    }
}