<?php
namespace controllers;

// Import required classes and dependencies
require_once './models/PrescriptionModel.php';
require_once './models/QuoteModel.php';
require_once './models/QuoteItemModel.php';
require_once './models/QuoteStatusModel.php';
require_once './models/UserModel.php';

class SinglePresController {
    private $presModel;
    private $quoteModel;
    private $quoteItemModel;
    private $quoteStatusModel;
    private $usersModel;

    public function __construct() {
        // Initialize model instances
        $this->presModel = new \models\PrescriptionModel();
        $this->quoteModel = new \models\QuoteModel();
        $this->quoteItemModel = new \models\QuoteItemModel();
        $this->quoteStatusModel = new \models\QuoteStatusModel();
        $this->usersModel = new \models\UserModel();
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
                header("Location: /user_prescriptions");
            }
            // If the user is logged in as anything other than "User," redirect to the pharmacy prescriptions page.
            else {
                // Set the 'pres_id' session variable
                $_SESSION["pres_id"] = $id;
                // Get prescription data by ID
                $prescriptions = $this->presModel->getPrescriptionById($id);
                // Load the view for displaying a single prescription
                require('./views/pharmacy/single_pres.php');
            }
        }
        // If no user is logged in, load the login view.
        else {
            header("Location: /");
        }
    }

    public function saveQuote() {
        // Get quote data from POST request
        $quote_data = $_POST["data"];
        $total = $quote_data["total"];
        $pres_id = $_SESSION["pres_id"];
        $rows = $quote_data["rows"];
        // Get the ID of the 'Pending' quote status
        $quote_status = ($this->quoteStatusModel->getQuoteStatusIdByStatus("Pending"))[0]["id"];

        // Create a new quote
        $quote = $this->quoteModel->createQuote($total, $pres_id, $quote_status);

        if (!$quote) {
            // Output 'error' if the quote creation fails
            echo "error";
        } else {
            foreach ($rows as $row) {
                // Create quote items for each row in the quote
                $quote_item = $this->quoteItemModel->createQuoteItem($row["drug"], $row["unit_price"], $row["qty"], $row["price"], $quote);

                if (!$quote_item) {
                    // Output 'error' if any quote item creation fails
                    echo "error";
                    break;
                }
            }

            // Send an email notification and check if it was successful
            $mailSent = $this->sendEmailNotification();

            if ($mailSent) {
                // Output 'success' if the email is sent successfully
                echo "success";
            } else {
                // Output 'error' if the email sending fails
                echo "error";
            }
        }
    }

    public function sendEmailNotification() {
        // Get the prescription ID from the session
        $pres_id = $_SESSION["pres_id"];
        // Get the customer ID associated with the prescription
        $customer_id = ($this->presModel->getPrescriptionById($pres_id))["user"];
        // Get the customer's email address
        $customer_email = ($this->usersModel->getUserById($customer_id))[0]["email"];

        // Define email details
        $to = $customer_email;
        $subject = "Med Pres - Quotation for your prescription";
        $message = "We've sent you a quotation for your prescription. Please log in to your Med Pres account to review it.";

        $headers = "From: udithabandara9@gmail.com\r\n";
        $headers .= "Reply-To: udithabandara9@gmail.com\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // Send the email and check if it was sent successfully
        $mailSent = mail($to, $subject, $message, $headers);

        if ($mailSent) {
            // Return true if the email is sent successfully
            return true;
        } else {
            // Return false if the email sending fails
            return false;
        }
    }
}
