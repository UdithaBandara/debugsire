<?php
namespace controllers;

// Import required classes and dependencies
require_once 'helpers/FormValidator.php';
require_once './models/PrescriptionModel.php';
require_once './models/ImageModel.php';

class UserPrescriptionsController {
    private $presModel;
    private $imagesModel;

    public function __construct() {
        // Create instances of PrescriptionModel and ImageModel
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
                // Get the user's ID from the session
                $user_id = $_SESSION["id"];

                // Retrieve prescriptions associated with the user
                $preses = $this->presModel->getPrescriptionByUserId($user_id);
                $prescriptions = array();

                if ($preses) {
                    // Process each prescription and associated images
                    foreach ($preses as $pres) {
                        // Retrieve images related to the prescription
                        $images = $this->imagesModel->getImagesByPrescriptionId($pres["id"]);

                        // Build an array representing prescription details and associated images
                        $prescriptions[] = array(
                            'id' => $pres['id'],
                            'note' => $pres['note'],
                            'delivery_address' => $pres['delivery_address'],
                            'delivery_time' => $pres['delivery_time'],
                            'images' => $images,
                        );
                    }
                }

                // Load the view to display the user's prescriptions
                require('./views/users/prescriptions.php');
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

    public function savePrescription() {
        // Create a FormValidator instance
        $validator = new namespace\helpers\FormValidator();

        // Retrieve form data
        $address = $_POST["address"];
        $time = $_POST["time"];
        $note = $_POST["note"];
        $images = $_FILES["images"];

        // Validate form fields
        $validator->validateField($address, "Delivery Address", ['validateRequired']);
        $validator->validateFieldLength($address, 255,"Delivery Address", ['validateLength']);
        $validator->validateField($time, "Delivery Time", ['validateRequired']);
        $validator->validateField($note, "Delivery Note", ['validateRequired']);
        $validator->validateFieldLength($note, 2000,"Delivery Note", ['validateLength']);
        $validator->validateField($images, "Prescription Images", ['validateRequired']);
        $validator->validateField($images, "Prescription Images", ['validateFileCount']);
        $validator->validateField($images, "Prescription Images", ['validateFileType']);

        if ($validator->hasErrors()) {
            // If there are validation errors, store them in the session and redirect back
            $_SESSION['errors'] = $validator->getErrors();
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            // If validation passes, proceed to save the prescription
            $user_id = $_SESSION["id"];
            $result = $this->presModel->createPrescription($note, $address, $time, $user_id);

            if ($result) {
                $pres_id = $result;

                $uploadDirectory = 'assets/images/uploads/';

                // Upload each image associated with the prescription
                foreach ($images['tmp_name'] as $key => $tmpName) {
                    $originalFileName = $images['name'][$key];
                    $timestamp = time();
                    $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
                    $newFileName = $pres_id . '_' . $timestamp . '_' . $key . '.' . $fileExtension;

                    $targetFilePath = $uploadDirectory . $newFileName;

                    if (move_uploaded_file($tmpName, $targetFilePath)) {
                        $this->imagesModel->createImage($targetFilePath, $pres_id);
                    } else {
                        // Handle errors during file upload
                        $_SESSION['errors'] = ["Something went wrong with file uploading. Please try again."];
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                        break;
                    }
                }

                // Redirect with success message after successfully saving the prescription
                $_SESSION['success'] = "Your prescription saved successfully. A quotation will be sent to you soon.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
            } else {
                // Handle errors if prescription creation fails
                $_SESSION['errors'] = ["Something went wrong. Please try again."];
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
        }
    }
}
