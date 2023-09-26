<?php
namespace models;

// Import the Database class
require_once './config/Database.php';

class QuoteItemModel {
    private $db;

    // Constructor initializes the database connection
    public function __construct() {
        $this->db = new \Database();
    }

    // Method to create a new quote item in the database
    public function createQuoteItem($drug, $unitPrice, $qty, $price, $quoteId) {
        // Escape user inputs to prevent SQL injection
        $drug = $this->db->conn->real_escape_string($drug);
        $unitPrice = $this->db->conn->real_escape_string($unitPrice);
        $qty = $this->db->conn->real_escape_string($qty);
        $price = $this->db->conn->real_escape_string($price);
        $quoteId = $this->db->conn->real_escape_string($quoteId);

        // Construct the SQL query for inserting a new quote item
        $query = "INSERT INTO `quote_items` (`drug`, `unit_price`, `qty`, `price`, `quotes_id`) VALUES ('$drug', $unitPrice, $qty, $price, $quoteId)";

        // Execute the query and check if it was successful
        $result = $this->db->query($query);

        // Return the ID of the newly inserted item on success, or false on failure
        if ($result) {
            return $this->db->getLastInsertId();
        } else {
            return false;
        }
    }

    // Method to retrieve quote items associated with a specific quote ID
    public function getQuoteItemsByQuoteId($quoteId) {
        // Escape the quote ID to prevent SQL injection
        $quoteId = $this->db->conn->real_escape_string($quoteId);

        // Construct the SQL query to retrieve quote items for a given quote ID
        $query = "SELECT * FROM `quote_items` WHERE `quotes_id` = $quoteId";

        // Execute the query and return the result set on success, or false on failure
        $result = $this->db->query($query);

        if ($result) {
            return $this->db->fetchAll($result);
        } else {
            return false;
        }
    }
}
