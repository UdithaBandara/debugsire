<?php
namespace controllers;

// Import required classes and dependencies
require_once 'helpers/FormValidator.php';
require_once 'helpers/Common.php';
require_once './config/Database.php';
require_once './models/UserModel.php';
require_once './models/UserTypeModel.php';

class AuthController {
    private $userModel;
    private $userTypeModel;

    public function __construct() {
        // Initialize the user model and user type model when creating an instance of the AuthController
        $this->userModel = new \models\UserModel();
        $this->userTypeModel = new \models\UserTypeModel();
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
                header("Location: /pharmacy_prescriptions");
            }
        }
        // If no user is logged in, load the login view.
        else {
            require('./views/login.php');
        }
    }

    public function register() {
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
                header("Location: /pharmacy_prescriptions");
            }
        }
        // If no user is logged in, load the register view.
        else {
            require('./views/register.php');
        }
    }

    public function loginAction() {
        // Handle user login
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        // Attempt to retrieve a user with the provided email and password
        $users = $this->userModel->getUserByEmailAndPassword($email, $password);

        if (count($users) == 0) {
            // If no user is found, set an error message and redirect back to the login page
            $_SESSION['error'] = "Incorrect email or password.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            // If a user is found, set session variables and redirect based on user type
            $user = $users[0];
            $user_type = ($this->userTypeModel->getUserTypeById($user["user_type_id"]))[0]["user_type"];
            $_SESSION["logged_in"] = true;
            $_SESSION["name"] = $user["name"];
            $_SESSION["user_type"] = $user_type;
            $_SESSION["email"] = $user["email"];
            $_SESSION["id"] = $user["id"];

            // Redirect the user based on their user type
            if ($user_type == "User") {
                header("Location: /user_prescriptions");
            } else if ($user_type == "Pharmacy") {
                header("Location: /pharmacy_prescriptions");
            }
        }
    }

    public function logoutAction() {
        // Log the user out by destroying the session and redirecting to the home page
        session_destroy();
        header('Location: /');
        exit;
    }

    public function registerUser() {
        // Handle user registration
        $validator = new namespace\helpers\FormValidator();

        // Retrieve user input data from the registration form
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $address = $_POST['address'];
        $mobile = $_POST['mobile'];
        $dob = $_POST['dob'];

        // Validate user input using various validation functions
        $validator->validateField($name, "Name", ['validateRequired']);
        $validator->validateField($email, "Email", ['validateRequired']);
        $validator->validateField($email, "Email", ['validateEmail']);
        $validator->validateField($password, "Password", ['validateRequired']);
        $validator->validateField($password, "Password", ['validatePassword']);
        $validator->validateField($confirm_password, "Confirm Password", ['validateRequired']);
        $validator->validateConfirmFields($password, $confirm_password, "Password", ['validateConfirm']);
        $validator->validateField($address, "Address", ['validateRequired']);
        $validator->validateFieldLength($address, 255, "Address", ['validateLength']);
        $validator->validateField($mobile, "Mobile Phone", ['validateRequired']);
        $validator->validateFieldLength($mobile, 10, "Mobile Phone", ['validateLength']);
        $validator->validateField($dob, "Date of Birth", ['validateRequired']);

        if ($validator->hasErrors()) {
            // If there are validation errors, set the errors in the session and redirect back to the registration page
            $_SESSION['errors'] = $validator->getErrors();
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            // Check if a user with the same email already exists
            $users_em = $this->userModel->getUserByEmail($email);

            if (count($users_em) > 0) {
                // If a user with the same email exists, set an error message and redirect back to the registration page
                $errors = ['A user with the email you entered already exists.'];
                $_SESSION['errors'] = $errors;
                header("Location: " . $_SERVER['HTTP_REFERER']);
            } else {
                // Create a new user with the provided data
                $encrypt_password = md5($password);
                $user_type = ($this->userTypeModel->getUserTypeIdByType("User"))[0]["id"];

                $result = $this->userModel->createUser($name, $address, $mobile, $dob, $email, $encrypt_password, $user_type);

                if ($result) {
                    // If user creation is successful, set a success message and redirect to the home page
                    $_SESSION['success'] = "You have registered successfully. Please login.";
                    header("Location: /");
                } else {
                    // If there is an error during user creation, set an error message and redirect back to the registration page
                    $errors = ['Something went wrong. Please try again.'];
                    $_SESSION['errors'] = $errors;
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                }
            }
        }
    }
}
