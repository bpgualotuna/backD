<?php

declare(strict_types=1);

namespace Config;

use MongoDB\Client;
use MongoDB\Database;


class Database
{
    private static ?Database $instance = null;
    private \MongoDB\Database $db;

    private function __construct()
    {
        $uri    = $_ENV['MONGODB_URI'] ?? 'mongodb://localhost:27017';
        $dbName = $_ENV['MONGODB_DB']  ?? 'students_db';

        $client   = new Client($uri);
        $this->db = $client->selectDatabase($dbName);
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getDb(): \MongoDB\Database
    {
        return $this->db;
    }
}
