<?php
require_once 'Config/Config.php';
class Connection
{
    private $connect;
    public function __construct()
    {
        $pdo = "mysql:host=" . HOST . ";dbname=" . DATABASE;

        try {
            $this->connect = new PDO($pdo, USER, PASSWORD);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error in the connection" . $e->getMessage();
        }
    }

    public function connect()
    {
        return $this->connect;
    }
}
