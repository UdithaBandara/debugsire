<?php
namespace models;

// Import the Database class
require_once './config/Database.php';

class QuoteModel {
    private $db;

    // Constructor to initialize the QuoteModel with a Database instance
    public function __construct() {
        $this->db = new \Database();
    }

    // Method to create a new quote in the database
    public function createQuote($total, $prescriptionId, $quoteStatusId) {
        // Sanitize input values to prevent SQL injection
        $total = $this->db->conn->real_escape_string($total);
        $prescriptionId = $this->db->conn->real_escape_string($prescriptionId);
        $quoteStatusId = $this->db->conn->real_escape_string($quoteStatusId);

        // Build the SQL query for inserting a new quote
        $query = "INSERT INTO `quotes` (`total`, `prescription_id`, `quote_status_id`) VALUES ($total, $prescriptionId, $quoteStatusId)";

        // Execute the query and check for success
        $result = $this->db->query($query);

        // If the query was successful, return the last inserted ID
        if ($result) {
            return $this->db->getLastInsertId();
        } else {
            // If the query failed, return false
            return false;
        }
    }

    // Method to retrieve all quotes from the database
    public function getAllQuotes() {
        // Build the SQL query for selecting all quotes
        $query = "SELECT * FROM `quotes`";

        // Execute the query and check for success
        $result = $this->db->query($query);

        // If the query was successful, return all fetched rows
        if ($result) {
            return $this->db->fetchAll($result);
        } else {
            // If the query failed, return false
            return false;
        }
    }

    // Method to retrieve quotes by prescription ID
    public function getQuoteByPrescriptionId($id) {
        // Sanitize the input ID
        $id = $this->db->conn->real_escape_string($id);

        // Build the SQL query for selecting quotes by prescription ID
        $query = "SELECT * FROM `quotes` WHERE `prescription_id` = '$id'";

        // Execute the query and check for success
        $result = $this->db->query($query);

        // If the query was successful, return all fetched rows
        if ($result) {
            return $this->db->fetchAll($result);
        } else {
            // If the query failed, return false
            return false;
        }
    }

    // Method to retrieve a quote by its ID
    public function getQuoteById($id) {
        // Sanitize the input ID
        $id = $this->db->conn->real_escape_string($id);

        // Build the SQL query for selecting a quote by its ID
        $query = "SELECT * FROM `quotes` WHERE `id` = '$id'";

        // Execute the query and check for success
        $result = $this->db->query($query);

        // If the query was successful, return all fetched rows
        if ($result) {
            return $this->db->fetchAll($result);
        } else {
            // If the query failed, return false
            return false;
        }
    }

    // Method to update the status of a quote
    public function updateQuoteStatus($quote_id, $status_id) {
        // Sanitize the input IDs
        $quote_id = $this->db->conn->real_escape_string($quote_id);
        $status_id = $this->db->conn->real_escape_string($status_id);

        // Build the SQL query for updating the quote status
        $query = "UPDATE quotes SET quote_status_id='$status_id' WHERE id='$quote_id'";

        // Execute the query and check for success
        $result = $this->db->query($query);

        // If the query was successful, return true
        if ($result) {
            return true;
        } else {
            // If the query failed, return false
            return false;
        }
    }
}
