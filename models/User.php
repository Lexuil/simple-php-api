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

    // Create User
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '
            SET
                firstname = :firstname,
                lastname = :lastname,
                email = :email,
                phone = :phone,
                birthday = :birthday,
                password = :password';

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->birthday = htmlspecialchars(strip_tags($this->birthday));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Hash Password
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind Data
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':birthday', $this->birthday);
        $stmt->bindParam(':password', $this->password);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

}