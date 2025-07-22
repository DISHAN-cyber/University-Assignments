<?php
class Database {
    public static $connection;

    public static function connect() {
        self::$connection = new mysqli("localhost", "root", "RY@200760y", "eshop", "3306");
        if (self::$connection->connect_error) {
            die("Connection failed: " . self::$connection->connect_error);
        }
    }

    public static function search($query) {
        $result = self::$connection->query($query);
        if (!$result) {
            die("Query failed: " . self::$connection->error);
        }
        return $result;
    }

    public static function iud($query) {
        $result = self::$connection->query($query);
        if (!$result) {
            die("Query failed: " . self::$connection->error);
        }
        return $result;
    }

    public static function prepare($query) {
        $stmt = self::$connection->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . self::$connection->error);
        }
        return $stmt;
    }
}

Database::connect();
?>
