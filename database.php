<?php
    class Database {
        private static $instance = null;
        
        private $pdo;
        
        private function __construct() {
            $host = 'localhost';
            $dbname = 'db_funeraria';
            $username = 'root';
            $password = '';
            
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$dbname",
                $username,
                $password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] 
            );
        }
        
        public static function getInstance() {
            if (!self::$instance) {
                self::$instance = new Database();
            }
            
            return self::$instance->pdo;
        }
        
        private function __clone() {}
    }
?>