<?php
require_once '../configuration.php';

class Database {
    private $connection;

    public function __construct() {
        $config = new JConfig();
        $this->connection = new mysqli($config->host, $config->user, $config->password, $config->db);

        if (!$this->connection->set_charset("utf8")) {
            die('Error loading character set utf8: ' . $this->connection->error);
        }

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function query($sql) {
        return $this->connection->query($sql);
    }

    public function escape_string($string) {
        return $this->connection->real_escape_string($string);
    }

    public function __destruct() {
        $this->connection->close();
    }
}
