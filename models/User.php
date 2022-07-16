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
    public $identification;
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
        // Clean data
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->identification = htmlspecialchars(strip_tags($this->identification));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->birthday = htmlspecialchars(strip_tags($this->birthday));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Validate data is not empty
        if (empty($this->firstname) || empty($this->lastname) || empty($this->identification) || empty($this->email) || empty($this->phone) || empty($this->birthday) || empty($this->password)) {
            return 'all fields are required';
        }

        // check if email is valid
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return 'email is not valid';
        }
        // check if phone is valid
        if (!preg_match('/^[0-9]{10}$/', $this->phone)) {
            return 'phone is not valid';
        }
        // check if birthday is valid
        if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $this->birthday)) {
            return 'birthday is not valid';
        }
        // check if password is valid
        if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $this->password)) {
            return 'password is not valid';
        }

        // check if email already exists
        $query = 'SELECT email FROM ' . $this->table . ' WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return 'email already exists';
        }
        // check if phone already exists
        $query = 'SELECT phone FROM ' . $this->table . ' WHERE phone = :phone';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return 'phone already exists';
        }
        // check if identification already exists
        $query = 'SELECT identification FROM ' . $this->table . ' WHERE identification = :identification';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':identification', $this->identification);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return 'identification already exists';
        }

        // Create query
        $query = 'INSERT INTO ' . $this->table . '
            SET
                firstname = :firstname,
                lastname = :lastname,
                identification = :identification,
                email = :email,
                phone = :phone,
                birthday = :birthday,
                password = :password';

        $stmt = $this->conn->prepare($query);

        // Hash Password
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind Data
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':identification', $this->identification);
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

        return 'User Created';
    }

}