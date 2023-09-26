<?php
namespace controllers;

// Import required classes and dependencies
require_once './models/QuoteModel.php';
require_once './models/QuoteStatusModel.php';
require_once './models/PrescriptionModel.php';

class UserQuotationsController {
    private $quoteModel;
    private $quoteStatusModel;
    private $presModel;

    public function __construct() {
        // Initialize instances of the required models
        $this->quoteModel = new \models\QuoteModel();
        $this->quoteStatusModel = new \models\QuoteStatusModel();
        $this->presModel = new \models\PrescriptionModel();
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
                // Retrieve the user's ID from the session
                $user_id = $_SESSION["id"];

                // Get prescriptions associated with the user
                $prescriptions = $this->presModel->getPrescriptionByUserId($user_id);

                // Initialize an empty array to store quotes
                $quotes = array();

                // Loop through each prescription
                foreach ($prescriptions as $prescription) {
                    // Get the prescription ID
                    $pres_id = $prescription["id"];

                    // Get quotes associated with the prescription
                    $quotesByPres = $this->quoteModel->getQuoteByPrescriptionId($pres_id);

                    // Loop through each quote associated with the prescription
                    foreach ($quotesByPres as $quoteByPres) {
                        // Get the status ID for the quote
                        $status_id = $quoteByPres["quote_status_id"];

                        // Get the status text based on the status ID
                        $status = ($this->quoteStatusModel->getQuoteStatusById($status_id))[0]["status"];

                        // Add the quote information to the quotes array
                        $quotes[] = array(
                            'id' => $quoteByPres["id"],
                            'total' => $quoteByPres["total"],
                            'pres' => $quoteByPres["prescription_id"],
                            'status' => $status
                        );
                    }
                }

                // Load the view for displaying user quotations
                require('./views/users/quotations.php');
            }
            // If the user is logged in as anything other than "User," redirect to the pharmacy prescriptions page.
            else {
                header("Location: /pharmacy_prescriptions");
            }
        }
        // If no user is logged in, load the login view.
        else {
            header("Location: /");
        }
    }
}
