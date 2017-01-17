<?php


class ConfigService
{

    static $instance = null;
    protected $config = array();

    private function __construct()
    {
        $this->includeConfigFiles();
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new ConfigService();
        }

        return self::$instance;
    }

    /**
     * Include the entire config folder and store it in $this->config
     */
    protected function includeConfigFiles()
    {
        global $config;

        $files = scandir(CONFIG_FOLDER);

        foreach ($files as $file) {
            if (strstr($file, '.php')) {
                include_once CONFIG_FOLDER . $file;
            }
        }

        if (!empty($config)) {
            $this->config = $config;
        }
    }

    /**
     * Get config
     * @param $config_name
     * @return mixed
     */
    public static function get($config_name)
    {
        return self::getInstance()->config[$config_name];
    }

    /**
     * Get environment config
     * @param $config_name
     * @return mixed
     */
    public static function getEnv($config_name)
    {
        return self::get('env')[$config_name];
    }

    /**
     * Return database config
     * @param $config_name
     * @return mixed
     */
    public static function getDB($config_name)
    {
        return self::get('database')[$config_name];
    }

}