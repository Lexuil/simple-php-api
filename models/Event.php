<?php

class Event
{
    private $conn;
    private $table = 'events';

    public $id;
    public $name;
    public $country;
    public $city;
    public $address;
    public $date;
    public $description;
    public $cant;
    public $image_url;
    public $created_at;
    public $updated_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function all()
    {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY id DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function create()
    {
        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->country = htmlspecialchars(strip_tags($this->country));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->cant = htmlspecialchars(strip_tags($this->cant));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));

        // Validate data is not empty
        if (empty($this->name) || empty($this->country) || empty($this->city) || empty($this->address) || empty($this->date) || empty($this->description) || empty($this->cant) || empty($this->image_url)) {
            return 'all fields are required';
        }

        // Insert query
        $query = 'INSERT INTO ' . $this->table . '
                SET
                    name = :name,
                    country = :country,
                    city = :city,
                    address = :address,
                    date = :date,
                    description = :description,
                    cant = :cant,
                    image_url = :image_url';

        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':cant', $this->cant);
        $stmt->bindParam(':image_url', $this->image_url);

        // Execute query
        if ($stmt->execute()) {
            return 'user created successfully';
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return 'Error';

    }

}