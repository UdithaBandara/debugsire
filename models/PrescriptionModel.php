<?php
namespace models;

// Import the Database class
require_once './config/Database.php';

class PrescriptionModel {
    private $db; // Private property to hold a Database instance

    // Constructor to initialize the Database instance
    public function __construct() {
        $this->db = new \Database();
    }

    // Method to create a new prescription
    public function createPrescription($note, $deliveryAddress, $deliveryTime, $userId) {
        // Escape user inputs to prevent SQL injection
        $note = $this->db->conn->real_escape_string($note);
        $deliveryAddress = $this->db->conn->real_escape_string($deliveryAddress);
        $deliveryTime = $this->db->conn->real_escape_string($deliveryTime);
        $userId = $this->db->conn->real_escape_string($userId);

        // SQL query to insert a new prescription record
        $query = "INSERT INTO `prescription` (`note`, `delivery_address`, `delivery_time`, `users_id`) VALUES ('$note', '$deliveryAddress', '$deliveryTime', $userId)";

        // Execute the query
        $result = $this->db->query($query);

        // Check if the query was successful and return the last inserted ID
        if ($result) {
            return $this->db->getLastInsertId();
        } else {
            return false;
        }
    }

    // Method to retrieve all prescriptions
    public function getAllPrescriptions() {
        // SQL query to select all prescription records
        $query = "SELECT * FROM `prescription`";

        // Execute the query
        $result = $this->db->query($query);

        // Check if the query was successful and return the result as an array
        if ($result) {
            return $this->db->fetchAll($result);
        } else {
            return false;
        }
    }

    // Method to retrieve prescriptions by user ID
    public function getPrescriptionByUserId($id) {
        // Escape the user ID to prevent SQL injection
        $id = $this->db->conn->real_escape_string($id);

        // SQL query to select prescription records by user ID
        $query = "SELECT * FROM `prescription` WHERE `users_id` = '$id'";

        // Execute the query
        $result = $this->db->query($query);

        // Check if the query was successful and return the result as an array
        if ($result) {
            return $this->db->fetchAll($result);
        } else {
            return false;
        }
    }

    // Method to retrieve a prescription by its ID, including associated images
    public function getPrescriptionById($id) {
        // Escape the prescription ID to prevent SQL injection
        $id = $this->db->conn->real_escape_string($id);

        // SQL query to select a prescription record by its ID
        $query = "SELECT * FROM `prescription` WHERE `id` = '$id'";

        // Execute the query
        $result = $this->db->query($query);

        // Check if the query was successful
        if ($result) {
            $prescriptions = array();

            // Fetch the prescription data as an array
            $rows = $this->db->fetchAll($result);
            $prescriptionId = $rows[0]['id'];

            // Check if the prescription data for this ID has already been processed
            if (!isset($prescriptions[$prescriptionId])) {
                // Retrieve associated images for the prescription
                $image_result = $this->db->query("SELECT image FROM images WHERE prescription_id='$prescriptionId'");
                $images = $this->db->fetchAll($image_result);

                // Create an array to store prescription details and associated images
                $prescriptions = array(
                    'id' => $rows[0]['id'],
                    'note' => $rows[0]['note'],
                    'delivery_address' => $rows[0]['delivery_address'],
                    'delivery_time' => $rows[0]['delivery_time'],
                    'images' => $images,
                    'user' => $rows[0]['users_id'],
                );
            }

            // Return the prescription details
            return $prescriptions;
        } else {
            return false;
        }
    }
}
