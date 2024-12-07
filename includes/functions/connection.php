<?php

if (!defined('ABSPATH')) {
    die('Direct access not allowed.');
}

class DBConnection {
    private $connection;
    private $prefix;

    public function __construct() {

        // Establish the connection.
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_error) {
            throw new Exception('Database connection failed: ' . $this->connection->connect_error);
        }

        // Set the table prefix.
        $this->prefix = defined('DB_PREFIX') ? DB_PREFIX : '';
    }

    public function get_connection() {
        return $this->connection;
    }

    public function prefix() {
        return $this->prefix;
    }

    public function execute_query($query, $params = [], $types = '', $m='') {
        $stmt = $this->connection->prepare($query);

        if ($stmt === false) {
            throw new Exception('Query preparation failed: ' . $this->connection->error);
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        if ($stmt->errno) {
            throw new Exception('Query execution failed: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }

    public function close() {
        $this->connection->close();
    }
}

// Instantiate the database connection and store it globally.
global $db;
$db = new DBConnection();
