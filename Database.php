<?php
class Database
{
    private $conn;

    public function getConnection()
    {
        $config = include __DIR__ . '/config/database.php';
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $config['host'] . ";dbname=" . $config['database'],
                $config['username'],
                $config['password']
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Errore: " . $e->getMessage();
        }
        return $this->conn;
    }
}
