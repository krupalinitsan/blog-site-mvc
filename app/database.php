<?php

class Database
{
    protected $host = 'localhost';
    protected $user = 'root';
    protected $pass = '';
    protected $db = 'blog-site';

    public function dbconnect()
    {
        $connection= new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        return $connection;
    }
}
?>
