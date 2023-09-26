<?php
namespace controllers\helpers;

class Common {
    // This function checks if a user is logged in by examining the PHP session data.
    function sessionCheckLoggedIn() {
        // Check if the "logged_in" key exists in the session and if its value is true.
        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
            // If the user is logged in, return their user type from the session data.
            return $_SESSION["user_type"];
        } else {
            // If the user is not logged in or the "logged_in" key is not set to true, return false.
            return false;
        }
    }
}