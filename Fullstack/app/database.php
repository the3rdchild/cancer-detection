<?php
class Database {
    private static $dbName = 'cancer_detection';
    private static $dbHost = 'localhost';
    private static $dbUsername = 'root';
    private static $dbUserPassword = ''; 

    private static $cont = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect() {
        if (null == self::$cont) {
            try {
                self::$cont = new PDO(
                    "mysql:host=".self::$dbHost.";dbname=".self::$dbName,
                    self::$dbUsername,
                    self::$dbUserPassword,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $e) {
                error_log($e->getMessage(), 3, __DIR__ . '/logs/database_error.log');
                die('Database connection error. Please contact administrator.');
            }
        }
        return self::$cont;
    }

    public static function disconnect() {
        self::$cont = null;
    }

    // Utility method to run queries safely
    public static function query($sql, $params = []) {
        $db = self::connect();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/logs/database_error.log');
            return false;
        }
    }

    // Transaction support
    public static function beginTransaction() {
        $db = self::connect();
        $db->beginTransaction();
    }

    public static function commitTransaction() {
        $db = self::connect();
        $db->commit();
    }

    public static function rollbackTransaction() {
        $db = self::connect();
        $db->rollBack();
    }
}
?>
