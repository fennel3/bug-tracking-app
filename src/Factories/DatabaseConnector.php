<?php

namespace ITBugTracking\Factories;

use PDO;

class DatabaseConnector
{
    public static function connect(): PDO
    {
        $db = new PDO(
            'mysql:host=DB;dbname=it-bug-tracking-api-simple',
            'root',
            'password'
        );
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
    }
}
