<?php

class DBService
{

    static $instance = null;
    protected $conn = null;

    private function __construct()
    {
        $this->connect();
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new DBService();
        }

        return self::$instance;
    }

    /**
     * TODO Connect to database and expose API
     */

    /**
     * Connect to database and keep reference locally
     */
    protected function connect()
    {
        $host = ConfigService::getDB('host');
        $username = ConfigService::getDB('user');
        $password = ConfigService::getDB('password');
        $driver = ConfigService::getDB('driver');
        $database = ConfigService::getDB('database');

        try {
            $this->conn = new PDO("$driver:host=$host;dbname=$database", $username, $password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * PHP will close the connection automatically, but if you desire to do it earlier, be my guest
     */
    public function closeConnection()
    {
        $this->conn = null;
    }

    /**
     * Execute SQL and return array of $modelClassName objects
     *
     * @param string $sql
     * @param string $modelClassName
     * @param array $params
     * @return ArrayObject
     */
    public function select($sql, $modelClassName, $params = array())
    {
        $sth = $this->conn->prepare($sql);
        $sth->execute($params);

        // transform array to $modelClassName[]
        $result = $sth->fetchAll(PDO::FETCH_CLASS, $modelClassName);
        return $result;
    }

    public function insert()
    {

    }

    public function delete()
    {

    }

    public function update()
    {

    }
}