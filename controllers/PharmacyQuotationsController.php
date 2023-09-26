<?php
namespace controllers;

// Import required classes and dependencies
require_once './models/QuoteModel.php';
require_once './models/QuoteStatusModel.php';

class PharmacyQuotationsController {
    private $quoteModel;
    private $quoteStatusModel;

    public function __construct() {
        // Initialize QuoteModel and QuoteStatusModel objects
        $this->quoteModel = new \models\QuoteModel();
        $this->quoteStatusModel = new \models\QuoteStatusModel();
    }

    public function index() {
        // Create an instance of the Common class from the 'namespace\helpers' namespace.
        $common = new namespace\helpers\Common();

        // Check if a user is logged in by calling the 'sessionCheckLoggedIn' method.
        $loggedIn = $common->sessionCheckLoggedIn();

        // If a user is logged in, determine their role and redirect accordingly.
        if($loggedIn) {
            // If the user is logged in as a "User," redirect to the user prescriptions page.
            if ($loggedIn === "User") {
                header("Location: /user_prescriptions");
            }
            // If the user is logged in as anything other than "User," redirect to the pharmacy prescriptions page.
            else {
                // Get all quotes from the QuoteModel
                $results = $this->quoteModel->getAllQuotes();
                $quotes = array();

                // Loop through the results to gather additional information
                foreach ($results as $result) {
                    // Extract the quote status ID
                    $quote_id = $result["quote_status_id"];

                    // Get the status for the current quote using QuoteStatusModel
                    $status = ($this->quoteStatusModel->getQuoteStatusById($quote_id))[0]["status"];

                    // Create an array containing quote information and status
                    $quotes[] = array(
                        'id' => $result["id"],
                        'total' => $result["total"],
                        'pres' => $result["prescription_id"],
                        'status' => $status
                    );
                }

                // Load a view to display the gathered quotations
                require('./views/pharmacy/quotations.php');
            }
        }
        // If no user is logged in, load the login view.
        else {
            header("Location: /");
        }
    }
}
