<?php

namespace App\Repository\DB;

use PDO;
use PDOException;

class DB
{
    protected $pdo = null;
    private $DB_HOST;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASSWORD;

    public function __construct($cfgData)
    {
        $this->DB_HOST = $cfgData['db_host'];
        $this->DB_NAME = $cfgData['db_name'];
        $this->DB_USER = $cfgData['db_user'];
        $this->DB_PASSWORD = $cfgData['db_password'];
    }

    public function connectDB()
    {
        if (is_null($this->pdo)) {
            try {
                $this->pdo = new PDO("mysql:host=" . $this->DB_HOST . ";dbname=" . $this->DB_NAME, $this->DB_USER, $this->DB_PASSWORD);
            } catch (PDOException $e) {
                print "ERROR: " . $e->getMessage();
                die();
            }

            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        
        return $this->pdo;
    }
}