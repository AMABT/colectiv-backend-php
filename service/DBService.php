<?php

class DBService
{

    static $instance = null;
    /* @var PDO */
    protected $conn = null;

    private function __construct()
    {
        $this->connect();

        if (defined('IS_TEST_ENV')) {
            $this->importTestData();
        }
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new DBService();
        }

        return self::$instance;
    }

    /**
     * Import database structure defined in migrate/database.sql
     * Get sql from migrate/test-data.sql and imports it in memory database
     */
    protected function importTestData()
    {
        // remove foreign keys
        $stm = $this->conn->prepare("SET FOREIGN_KEY_CHECKS = 0");
        $stm->execute();
        $stm->closeCursor();

        // drop all tables
        $tables = $this->conn->prepare("SHOW TABLES");
        $tables->execute();
        if ($result = $tables->fetchAll()) {
            foreach ($result as $row) {
                $stm = $this->conn->prepare('DROP TABLE IF EXISTS ' . $row[0]);
                $stm->execute();
                $stm->closeCursor();
            }
        }
        $tables->closeCursor();

        $files = array(MIGRATE_FOLDER . 'database.sql', MIGRATE_FOLDER . 'test-data.sql');

        foreach ($files as $filename) {

            $testSQL = file_get_contents($filename);

            $stm = $this->conn->prepare($testSQL);
            $stm->execute();
            $stm->closeCursor();
        }

        // set back foreign keys
        $stm = $this->conn->prepare("SET FOREIGN_KEY_CHECKS = 1");
        $stm->execute();
        $stm->closeCursor();
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
        $database = defined('IS_TEST_ENV') ? ConfigService::getDB('database_test') : ConfigService::getDB('database');

        try {
            $this->conn = new PDO("$driver:host=$host;dbname=$database", $username, $password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage() . "\n";
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
    public function select($sql, $modelClassName = null, $params = array())
    {
        $sth = $this->conn->prepare($sql);
        $sth->execute($params);

        if ($modelClassName === null) {
            // return basic array
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // transform array to $modelClassName[]
            $result = $sth->fetchAll(PDO::FETCH_CLASS, $modelClassName);
        }
        return $result;
    }

    /**
     *
     * @param $sql string example: INSERT INTO db_fruit (id, type, colour) VALUES (? ,? ,?)
     * @param $params array example: array($newId, $name, $color)
     * @return string last inserted id
     * @throws PDOException
     */
    public function insert($sql, $params = array())
    {
        $stm = $this->conn->prepare($sql);
        // use exec() because no results are returned
        $stm->execute($params);

        return $this->conn->lastInsertId();
    }

    /**
     * @param $sql string example: DELETE FROM MyGuests WHERE id = ?
     * @param array $params array()
     */
    public function delete($sql, $params = array())
    {
        // Prepare statement
        $stmt = $this->conn->prepare($sql);

        // execute the query
        $stmt->execute($params);
    }

    /**
     * @param $sql string example: UPDATE MyGuests SET lastname='Doe' WHERE id=2
     * @param array $params
     * @return int number of records UPDATED successfully
     */
    public function update($sql, $params = array())
    {
        // Prepare statement
        $stmt = $this->conn->prepare($sql);

        // execute the query
        $stmt->execute($params);

        return $stmt->rowCount();
    }
}