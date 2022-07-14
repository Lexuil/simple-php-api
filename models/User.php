<?php

class User
{
    // DB Params
    private $conn;
    private $table = 'users';

    // User Properties
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $birthday;
    public $password;
    public $created_at;
    public $updated_at;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get All Users
    public function all()
    {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY id DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

}