<?php
// Function to validate if a value is not empty (required field)
function validateRequired($value, $fieldName) {
    if (empty($value)) {
        return "$fieldName is required."; // Return an error message if the value is empty
    }
    return null; // Return null if the value is not empty (no error)
}

// Function to validate if two values match (e.g., password confirmation)
function validateConfirm($value1, $value2, $fieldName) {
    if ($value1 != $value2) {
        return "$fieldName fields do not match."; // Return an error message if the values do not match
    }
    return null; // Return null if the values match (no error)
}

// Function to validate the length of a value (e.g., maximum characters)
function validateLength($value, $length, $fieldName) {
    if (strlen($value) > $length) {
        return "Number of characters in $fieldName must be less than or equal to $length."; // Return an error message if the length exceeds the specified limit
    }
    return null; // Return null if the length is within the limit (no error)
}

// Function to validate if a value is a valid email address
function validateEmail($value, $fieldName) {
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return "Please enter a valid $fieldName."; // Return an error message if the value is not a valid email
    }
    return null; // Return null if the value is a valid email (no error)
}

// Function to validate the count of uploaded files (e.g., maximum file count)
function validateFileCount($files, $fieldName) {
    $fileCount = count($files['name']);
    if ($fileCount > 5) {
        return "You can upload a maximum of 5 $fieldName."; // Return an error message if the file count exceeds the limit
    }
    return null; // Return null if the file count is within the limit (no error)
}

// Function to validate the file type of uploaded files (e.g., allowed file extensions)
function validateFileType($files, $fieldName) {
    $fileCount = count($files['name']);
    for ($i = 0; $i < $fileCount; $i++) {
        $fileType = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));

        $allowedTypes = array("jpg", "jpeg", "png");
        if (!in_array($fileType, $allowedTypes)) {
            return "Only JPG, JPEG, and PNG files are accepted for $fieldName."; // Return an error message if the file type is not allowed
        }
    }
    return null; // Return null if all file types are allowed (no error)
}

// Function to validate a password based on specific criteria
function validatePassword($value, $fieldName) {
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $value)) {
        return "Please enter a valid $fieldName (minimum 8 characters, at least 1 uppercase letter, 1 lowercase letter, and 1 number)"; // Return an error message if the password does not meet the criteria
    }
    return null; // Return null if the password meets the criteria (no error)
}
