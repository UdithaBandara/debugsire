<?php
namespace models;

// Import the Database class
require_once './config/Database.php';

class ImageModel {
    private $db;

    public function __construct() {
        // Create a new instance of the Database class
        $this->db = new \Database();
    }

    public function createImage($imageFileName, $prescriptionId) {
        // Sanitize input data to prevent SQL injection
        $imageFileName = $this->db->conn->real_escape_string($imageFileName);
        $prescriptionId = $this->db->conn->real_escape_string($prescriptionId);

        // Construct the SQL query to insert an image record
        $query = "INSERT INTO `images` (`image`, `prescription_id`) VALUES ('$imageFileName', $prescriptionId)";

        // Execute the query and store the result
        $result = $this->db->query($query);

        // Check if the query was successful
        if ($result) {
            // Return the last inserted ID (typically an auto-incremented primary key)
            return $this->db->getLastInsertId();
        } else {
            // Return false if the query failed
            return false;
        }
    }

    public function getImagesByPrescriptionId($prescriptionId) {
        // Sanitize the prescription ID to prevent SQL injection
        $prescriptionId = $this->db->conn->real_escape_string($prescriptionId);

        // Construct the SQL query to retrieve images based on prescription ID
        $query = "SELECT * FROM `images` WHERE `prescription_id` = $prescriptionId";

        // Execute the query and store the result
        $result = $this->db->query($query);

        // Check if the query was successful
        if ($result) {
            // Fetch all rows from the result and return as an array
            return $this->db->fetchAll($result);
        } else {
            // Return false if the query failed
            return false;
        }
    }
}
