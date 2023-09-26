<?php
namespace controllers;

// Import required classes and dependencies
require_once './models/QuoteModel.php';
require_once './models/QuoteStatusModel.php';
require_once './models/QuoteItemModel.php';

class SingleQuotationController {
    private $quoteModel;
    private $quoteStatusModel;
    private $quoteItemModel;

    public function __construct() {
        // Create instances of required models
        $this->quoteModel = new \models\QuoteModel();
        $this->quoteStatusModel = new \models\QuoteStatusModel();
        $this->quoteItemModel = new \models\QuoteItemModel();
    }

    public function index($id) {
        // Create an instance of the Common class from the 'namespace\helpers' namespace.
        $common = new namespace\helpers\Common();

        // Check if a user is logged in by calling the 'sessionCheckLoggedIn' method.
        $loggedIn = $common->sessionCheckLoggedIn();

        // If a user is logged in, determine their role and redirect accordingly.
        if($loggedIn) {
            // If the user is logged in as a "User," redirect to the user prescriptions page.
            if ($loggedIn === "User") {
                // Retrieve a single quotation by its ID
                $quote = $this->quoteModel->getQuoteById($id);
                $quote_id = $quote[0]["id"];
                $quote_status_id = $quote[0]["quote_status_id"];

                // Get the items associated with the quotation
                $quote_items = $this->quoteItemModel->getQuoteItemsByQuoteId($quote_id);

                // Get the status of the quotation
                $status = ($this->quoteStatusModel->getQuoteStatusById($quote_status_id))[0]["status"];

                // Load the view to display the single quotation
                require('./views/users/single_quote.php');
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

    public function changeStatus($id, $status) {
        // Get the ID of the new status based on the provided status name
        $new_status_id = ($this->quoteStatusModel->getQuoteStatusIdByStatus($status))[0]["id"];

        // Update the status of the quotation
        $this->quoteModel->updateQuoteStatus($id, $new_status_id);

        // Set a success message for the user
        $_SESSION['success'] = "You have $status the quotation.";

        // Redirect back to the previous page
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}
