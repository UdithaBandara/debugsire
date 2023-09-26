<?php
namespace controllers;

// Import required classes and dependencies
require_once 'helpers/Common.php';
require_once './models/PrescriptionModel.php';
require_once './models/ImageModel.php';

class PharmacyPrescriptionController {
    private $presModel;
    private $imagesModel;

    public function __construct() {
        // Initialize the PrescriptionModel and ImageModel when creating an instance of the PharmacyPrescriptionController
        $this->presModel = new \models\PrescriptionModel();
        $this->imagesModel = new \models\ImageModel();
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
            // If the user is logged in as anything other than "User," display to the pharmacy prescriptions page.
            else {
                // Retrieve all prescriptions from the database
                $preses = $this->presModel->getAllPrescriptions();

                if ($preses) {
                    $prescriptions = array(); // Initialize an array to store prescription information

                    // Iterate through each prescription and retrieve associated images
                    foreach ($preses as $pres) {
                        $images = $this->imagesModel->getImagesByPrescriptionId($pres["id"]);

                        // Create an array representing the prescription with associated images
                        $prescriptions[] = array(
                            'id' => $pres['id'],
                            'note' => $pres['note'],
                            'delivery_address' => $pres['delivery_address'],
                            'delivery_time' => $pres['delivery_time'],
                            'images' => $images,
                        );
                    }
                }

                // Load the pharmacy prescriptions view, passing the $prescriptions array
                require('./views/pharmacy/prescriptions.php');
            }
        }
        // If no user is logged in, load the login view.
        else {
            header("Location: /");
        }
    }
}
