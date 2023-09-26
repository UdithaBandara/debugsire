<?php
class Database
{
    // Private properties to store database connection details
    private $host = 'localhost';     // Database host name
    private $port = '3306';          // Database port number
    private $username = 'root';      // Database username
    private $password = '1234';      // Database password
    private $database = 'med_pres';  // Database name

    // Public property to hold the database connection
    public $conn;

    // Constructor method to establish a database connection
    public function __construct() {
        // Create a new MySQLi (MySQL improved) connection using the provided credentials
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);

        // Check if the connection failed
        if ($this->conn->connect_error) {
            // If the connection fails, terminate the script and display an error message
            die('Connection failed: ' . $this->conn->connect_error);
        }
    }

    // Method to execute a SQL query
    public function query($query) {
        // Execute the query using the database connection
        $result = $this->conn->query($query);

        // Check if the query execution resulted in an error
        if (!$result) {
            // If there's an error, terminate the script and display the error message
            die('Error: ' . $this->conn->error);
        }

        // Return the query result
        return $result;
    }

    // Method to fetch all rows from a query result
    public function fetchAll($result) {
        $rows = array(); // Initialize an empty array to store rows

        // Check if there are rows in the result
        if ($result->num_rows > 0) {
            // Iterate through the result rows and store them in the $rows array
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }

        // Return the array of fetched rows
        return $rows;
    }

    // Method to get the last inserted ID after an INSERT operation
    public function getLastInsertId() {
        return $this->conn->insert_id; // Return the last inserted ID
    }
}
