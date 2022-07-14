<?php

class Database
{
    // DB Params
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    private $ssl_mode = 'require';
    private $sslrootcert = __DIR__ . '/config/ca-certificate.crt';
    private $conn;

    function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->port = $_ENV['DB_PORT'];
    }

    // DB Connect
    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host .
                ';dbname=' . $this->db_name .
                ';port=' . $this->port .
                ';port=' . $this->port .
                ';sslmode=' . $this->ssl_mode .
                ';sslrootcert=' . $this->sslrootcert,
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }

    /*DB user table factory
    * table: users
     * id: int(11) NOT NULL AUTO_INCREMENT
     * firstname: varchar(500) NOT NULL
     * lastname: varchar(500) NOT NULL
     * email: varchar(500) NOT NULL UNIQUE
     * phone: varchar(500) NOT NULL UNIQUE
     * birthday: date NOT NULL
     * password: varchar(1000) NOT NULL
     * created_at: timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
     * updated_at: timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    */
    public function userTable()
    {
        $query = 'CREATE TABLE IF NOT EXISTS users (
            id int(11) NOT NULL AUTO_INCREMENT,
            firstname varchar(500) NOT NULL,
            lastname varchar(500) NOT NULL,
            email varchar(500) NOT NULL UNIQUE,
            phone varchar(500) NOT NULL UNIQUE,
            birthday date NOT NULL,
            password varchar(1000) NOT NULL,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        )';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }
}