<?php

namespace App;

use PDO;

class SQLiteConnection
{
    private static ?PDO $pdo = null;

    /**
     * @return PDO
     */
    public static function connect(): PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO($_ENV['DATABASE_DSN']);
        }

        return self::$pdo;
    }
}
