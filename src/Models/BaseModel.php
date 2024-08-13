<?php
namespace App\Models;

use PDO;
use PDOException;

class BaseModel
{
    private $config;
    public $pdo;

    public function __construct()
    {
        $this->config = parse_ini_file('config.ini', false);
        $this->pdo = $this->connect();
    }

    /**
     * @return PDO|void
     */
    private function connect()
    {
        $host = $this->config['host'];
        $username = $this->config['username'];
        $password = $this->config['password'];
        $database = $this->config['database'];
        $port = $this->config['port'];

        try {
            $pdo = new PDO("mysql:host=$host;port=$port;dbname=$database;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}

//(new BaseModel());