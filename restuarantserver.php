<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'RestaurantDatabase.php';

class RestaurantPortal {
    private $db;

    public function __construct() {
        $this->db = new RestaurantDatabase();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'home';

        switch ($action) {
            case 'addReservation':
                $this->addReservation();
                break;
            case 'viewReservations':
                $this->viewReservations();
                break;
            default:
                $this->home();
        }
    }

    private function home() {
        include 'templates/home.php';
    }

    private function addReservation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerName = $_POST['customer_name'];
            $contactInfo = $_POST['contact_info'];
            $reservationTime = $_POST['reservation_time'];
            $numberOfGuests = $_POST['number_of_guests'];
            $specialRequests = $_POST['special_requests'];

            // Add the customer to the database
            $stmt = $this->db->connection->prepare(
                "INSERT INTO Customers (customerName, contactInfo) VALUES (?, ?)"
            );
            if (!$stmt) {
                die("Prepare failed: " . $this->db->connection->error);
            }
            $stmt->bind_param("ss", $customerName, $contactInfo);
            if (!$stmt->execute()) {
                die("Execution failed: " . $stmt->error);
            }

            // Get the newly inserted customer ID
            $customerId = $stmt->insert_id;
            $stmt->close();

            // Add reservation for the new customer
            $this->db->addReservation($customerId, $reservationTime, $numberOfGuests, $specialRequests);

            // Redirect to the View Reservations page
            header("Location: index.php?action=viewReservations&message=Reservation Added");
            exit;
        } else {
            // Display the add reservation form
            include 'templates/addReservation.php';
        }
    }

    private function viewReservations() {
        $reservations = $this->db->getAllReservations();
        include 'templates/viewReservations.php';
    }
}

$portal = new RestaurantPortal();
$portal->handleRequest();
?>
