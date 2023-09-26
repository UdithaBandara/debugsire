<?php
namespace models;

// Import the Database class
require_once './config/Database.php';

class UserModel {
    private $db;

    public function __construct() {
        // Create a new Database object for database interactions.
        $this->db = new \Database();
    }

    public function createUser($name, $address, $mobile, $dob, $email, $password, $user_type_id) {
        // Escape user inputs to prevent SQL injection.
        $name = $this->db->conn->real_escape_string($name);
        $address = $this->db->conn->real_escape_string($address);
        $mobile = $this->db->conn->real_escape_string($mobile);
        $dob = $this->db->conn->real_escape_string($dob);
        $email = $this->db->conn->real_escape_string($email);
        $password = $this->db->conn->real_escape_string($password);

        // Construct the SQL query for creating a new user.
        $query = "INSERT INTO `users` (`name`, `address`, `mobile`, `dob`, `email`, `password`, `user_type_id`) VALUES ('$name', '$address', '$mobile', '$dob', '$email', '$password', $user_type_id)";

        // Execute the query and check if it was successful.
        $result = $this->db->query($query);

        if ($result) {
            // Return the last inserted user ID on success.
            return $this->db->getLastInsertId();
        } else {
            // Return false on failure.
            return false;
        }
    }

    public function getUserByEmailAndPassword($email, $password) {
        // Escape user inputs to prevent SQL injection.
        $email = $this->db->conn->real_escape_string($email);
        $password = $this->db->conn->real_escape_string($password);

        // Construct the SQL query to fetch a user by email and password.
        $query = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password'";
        $result = $this->db->query($query);

        if ($result) {
            // Return user data as an array on success.
            return $this->db->fetchAll($result);
        } else {
            // Return false on failure.
            return false;
        }
    }

    public function getUserByEmail($email) {
        // Escape user input to prevent SQL injection.
        $email = $this->db->conn->real_escape_string($email);

        // Construct the SQL query to fetch a user by email.
        $query = "SELECT * FROM `users` WHERE `email` = '$email'";
        $result = $this->db->query($query);

        if ($result) {
            // Return user data as an array on success.
            return $this->db->fetchAll($result);
        } else {
            // Return false on failure.
            return false;
        }
    }

    public function getUserById($id) {
        // Escape user input to prevent SQL injection.
        $id = $this->db->conn->real_escape_string($id);

        // Construct the SQL query to fetch a user by ID.
        $query = "SELECT * FROM `users` WHERE `id` = '$id'";
        $result = $this->db->query($query);

        if ($result) {
            // Return user data as an array on success.
            return $this->db->fetchAll($result);
        } else {
            // Return false on failure.
            return false;
        }
    }
}
