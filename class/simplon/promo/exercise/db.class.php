<?php

/**
 * A static class to handle all database interactions.
 */

namespace Simplon\Promo\Exercise;

use \PDO;

class DB
{
    private static $db = null;

    const USER = 'exercise';
    const PASSWORD = 'exercise';
    const CONNECTION_STRING = 'mysql:host=localhost;dbname=exercise';

    /**
     * Get an initialised PDO database object.
     * Throws a PDOException on failure. Default FETCH_MODE is FETCH_ASSOC.
     *
     * @return A PDO database object.
     */
    public static function getDB()
    {
        if (self::$db) {
            return self::$db;
        } else {
            self::$db = new PDO(
                self::CONNECTION_STRING,
                self::USER,
                self::PASSWORD,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false
                ]
            );
            return self::$db;
        }
    }
}


// vim:set expandtab tabstop=4 shiftwidth=4 softtabstop=4:
