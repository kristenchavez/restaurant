<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class RestaurantDatabase {
    private $host = "localhost";
    private $port = "3306";
    private $database = "restaurant_reservations";
    private $user = "root";
    private $password = "kristenchavez"; 
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
        if ($this->connection->connect_error) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
        echo "Successfully connected to the database<br>";
    }

    public function addReservation($customerId, $reservationTime, $numberOfGuests, $specialRequests) {
        $stmt = $this->connection->prepare(
            "INSERT INTO reservations (customerId, reservationTime, numberOfGuests, specialRequests) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("isis", $customerId, $reservationTime, $numberOfGuests, $specialRequests);
        if ($stmt->execute()) {
            echo "Reservation added successfully<br>";
        } else {
            echo "Error adding reservation: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }

    public function getAllReservations() {
        $result = $this->connection->query("SELECT * FROM reservations");
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            echo "Error fetching reservations: " . $this->connection->error . "<br>";
            return [];
        }
    }

    public function addCustomer($customerName, $contactInfo) {
        $stmt = $this->connection->prepare(
            "INSERT INTO customers (customerName, contactInfo) VALUES (?, ?)"
        );
        $stmt->bind_param("ss", $customerName, $contactInfo);
        if ($stmt->execute()) {
            echo "Customer added successfully<br>";
        } else {
            echo "Error adding customer: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }

    public function getCustomerPreferences($customerId) {
        $stmt = $this->connection->prepare(
            "SELECT preferences FROM customers WHERE id = ?"
        );
        $stmt->bind_param("i", $customerId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } else {
            echo "Error fetching customer preferences: " . $stmt->error . "<br>";
            return null;
        }
        $stmt->close();
    }
}
?>
