<?php
namespace models;

// Import the Database class
require_once './config/Database.php';

// Define the 'QuoteStatusModel' class.
class QuoteStatusModel {
    // Declare a private property to hold a database connection.
    private $db;

    // Constructor method to initialize the class.
    public function __construct() {
        // Create a new instance of the 'Database' class to establish a database connection.
        $this->db = new \Database();
    }

    // Method to retrieve a quote status record by its 'id'.
    public function getQuoteStatusById($id) {
        // Build a SQL query to select all fields from the 'quote_status' table where the 'id' matches the provided parameter.
        $query = "SELECT * FROM `quote_status` WHERE `id` = '$id'";

        // Execute the SQL query using the database connection.
        $result = $this->db->query($query);

        // Check if the query execution was successful.
        if ($result) {
            // If successful, return the fetched results.
            return $this->db->fetchAll($result);
        } else {
            // If unsuccessful, return false to indicate an error.
            return false;
        }
    }

    // Method to retrieve a quote status record's 'id' by its 'status'.
    public function getQuoteStatusIdByStatus($status) {
        // Build a SQL query to select all fields from the 'quote_status' table where the 'status' matches the provided parameter.
        $query = "SELECT * FROM `quote_status` WHERE `status` = '$status'";

        // Execute the SQL query using the database connection.
        $result = $this->db->query($query);

        // Check if the query execution was successful.
        if ($result) {
            // If successful, return the fetched results.
            return $this->db->fetchAll($result);
        } else {
            // If unsuccessful, return false to indicate an error.
            return false;
        }
    }
}
