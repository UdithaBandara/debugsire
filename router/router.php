<?php
// Include necessary controller files
require_once './controllers/AuthController.php';
require_once './controllers/UserPrescriptionsController.php';
require_once './controllers/PharmacyPrescriptionController.php';
require_once './controllers/SinglePresController.php';
require_once './controllers/PharmacyQuotationsController.php';
require_once './controllers/UserQuotationsController.php';
require_once './controllers/SingleQuotationController.php';

// Get the current URL
$url = $_SERVER['REQUEST_URI'];
$urlComponents = explode('/', $url);

// Create instances of various controllers
$authController = new controllers\AuthController();
$userPrescriptionController = new controllers\UserPrescriptionsController();
$pharmacyPrescriptionController = new controllers\PharmacyPrescriptionController();
$singlePresController = new controllers\SinglePresController();
$pharmacyQuotationController = new controllers\PharmacyQuotationsController();
$userQuotationController = new controllers\UserQuotationsController();
$singleQuoteController = new controllers\SingleQuotationController();

try {
    // Determine the action based on the URL components
    switch ($urlComponents[1]) {
        case '':
            $authController->index(); // Display the main page
            break;
        case 'register':
            $authController->register(); // Display the registration form
            break;
        case 'login_action':
            $authController->loginAction(); // Process login action
            break;
        case 'reg_action':
            $authController->registerUser(); // Process user registration
            break;
        case 'logout':
            $authController->logoutAction(); // Process user logout
            break;
        case 'user_prescriptions':
            $userPrescriptionController->index(); // Display user prescriptions
            break;
        case 'save_prescriptions':
            $userPrescriptionController->savePrescription(); // Save user prescription
            break;
        case 'user_quotes':
            $userQuotationController->index(); // Display user quotations
            break;
        case 'single_quote':
            $singleQuoteController->index($urlComponents[2]); // Display a single quotation
            break;
        case 'change_status':
            $singleQuoteController->changeStatus($urlComponents[2], $urlComponents[3]); // Change quotation status
            break;
        case 'pharmacy_prescriptions':
            $pharmacyPrescriptionController->index(); // Display pharmacy prescriptions
            break;
        case 'single_pres':
            $singlePresController->index($urlComponents[2]); // Display a single prescription
            break;
        case 'save_quote':
            $singlePresController->saveQuote(); // Save a quotation
            break;
        case 'pharmacy_quotes':
            $pharmacyQuotationController->index(); // Display pharmacy quotations
            break;
        default:
            throw new Exception('not_found'); // Handle 404 error for invalid URL
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    $date = date('Y-m-d H:i:s', time());
    $errorLogMessage = $date . ': ' . $errorMessage . "\n";

    if ($errorMessage === 'not_found') {
        http_response_code(404);
        require('./views/error_pages/404.php'); // Display 404 error page
    } else {
        http_response_code(500);
        require('./views/error_pages/500.php'); // Display 500 error page
    }

    error_log($errorLogMessage, 3, './logs/error.log'); // Log the error message
}
