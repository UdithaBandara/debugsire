<?php
namespace models;

// Import the Database class
require_once './config/Database.php';

// Define a class called UserTypeModel.
class UserTypeModel {
    // Private property to store the database connection.
    private $db;

    // Constructor method to initialize the class and establish a database connection.
    public function __construct() {
        // Create a new instance of the Database class.
        $this->db = new \Database();
    }

    // Method to retrieve user type data by ID from the database.
    public function getUserTypeById($id) {
        // Escape any special characters in the $id parameter to prevent SQL injection.
        $id = $this->db->conn->real_escape_string($id);

        // Construct an SQL query to fetch data based on the provided ID.
        $query = "SELECT * FROM `user_type` WHERE `id` = '$id'";

        // Execute the query using the database connection.
        $result = $this->db->query($query);

        // Check if the query was successful.
        if ($result) {
            // If successful, return the fetched data.
            return $this->db->fetchAll($result);
        } else {
            // If the query failed, return false to indicate an error.
            return false;
        }
    }

    // Method to retrieve user type ID by type from the database.
    public function getUserTypeIdByType($type) {
        // Escape any special characters in the $type parameter to prevent SQL injection.
        $type = $this->db->conn->real_escape_string($type);

        // Construct an SQL query to fetch data based on the provided user type.
        $query = "SELECT * FROM `user_type` WHERE `user_type` = '$type'";

        // Execute the query using the database connection.
        $result = $this->db->query($query);

        // Check if the query was successful.
        if ($result) {
            // If successful, return the fetched data.
            return $this->db->fetchAll($result);
        } else {
            // If the query failed, return false to indicate an error.
            return false;
        }
    }
}
