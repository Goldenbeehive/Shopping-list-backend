<?php
class Database
{
    private string $host;
    private string $db;
    private $connection;
    private string $user;
    private string $pass;
    private bool $connSuccess;

    function __construct($host, $db, $user, $pass)
    {
        $this->host = $host;
        $this->db = $db;
        $this->user = $user;
        $this->pass = $pass;
    }
    function conn()
    {
        try {
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            $this->connSuccess = true;
        } catch (Exception $e) {
            echo "Connection failed" . $e->getMessage();
            $this->connSuccess = false;
        }
    }
    function check_conn(){
        return $this->connSuccess;
    }
    function prepare(string $order)
    {
        return $this->connection->prepare($order);
    }
    function __destruct()
    {
        $this->connection = null;
    }

}
?>