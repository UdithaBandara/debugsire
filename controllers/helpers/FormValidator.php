<?php
namespace controllers\helpers;

// Include the required validations file
require_once('validations.php');

class FormValidator {
    private $errors = []; // Private property to store validation errors

    // Method to validate a single field using a list of validation functions
    public function validateField($value, $fieldName, $validationFunctions) {
        foreach ($validationFunctions as $validationFunction) {
            // Call the validation function and store any error message returned
            $errorMessage = $validationFunction($value, $fieldName);

            // If there's an error message returned, store it in the errors array and break the loop
            if ($errorMessage !== null) {
                $this->errors[$fieldName] = $errorMessage;
                break;
            }
        }
    }

    // Method to validate two fields that need to match using a list of validation functions
    public function validateConfirmFields($value1, $value2, $fieldName, $validationFunctions) {
        foreach ($validationFunctions as $validationFunction) {
            // Call the validation function and store any error message returned
            $errorMessage = $validationFunction($value1, $value2, $fieldName);

            // If there's an error message returned, store it in the errors array and break the loop
            if ($errorMessage !== null) {
                $this->errors[$fieldName] = $errorMessage;
                break;
            }
        }
    }

    // Method to validate the length of a field using a list of validation functions
    public function validateFieldLength($value, $length, $fieldName, $validationFunctions) {
        foreach ($validationFunctions as $validationFunction) {
            // Call the validation function and store any error message returned
            $errorMessage = $validationFunction($value, $length, $fieldName);

            // If there's an error message returned, store it in the errors array and break the loop
            if ($errorMessage !== null) {
                $this->errors[$fieldName] = $errorMessage;
                break;
            }
        }
    }

    // Method to check if there are validation errors
    public function hasErrors() {
        return !empty($this->errors);
    }

    // Method to get the validation errors
    public function getErrors() {
        return $this->errors;
    }
}
