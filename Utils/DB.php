<?php


namespace Glas\Utils;

use PDO;


class DB
{
    private static $obj = null;
    private $pdo;

    private function __construct() {
        $this->connect();
    }

    private function connect() {
        $dsn = 'pgsql:host='.Settings::get('DB_HOST').';port='.Settings::get('DB_PORT').';dbname='.Settings::get('DB_NAME');
        try {
            $this->pdo = new PDO($dsn, Settings::get('DB_USER'), Settings::get('DB_PASSWORD'), array(PDO::ATTR_PERSISTENT => true));
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (\Exception $e) {
            exit ($e->getMessage());
        }
    }

    public static function pdo() {
        if (self::$obj == null) {
            self::$obj = new DB();
        }

        if (self::$obj->pdo == null) {
            self::$obj->connect();
        }

        return self::$obj->pdo;
    }
}