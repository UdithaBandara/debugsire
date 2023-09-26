<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include('includes/css.php') ?>
    <title>Med Pres - Register</title>
</head>
<body>
<?php include('includes/navbar.php') ?>

<div class="container">
    <div class="row mt-5 mb-3 justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center">Register</h3>
                        </div>
                    </div>

                    <form action="/reg_action" method="post" id="reg_form">
                        <?php
                        if (isset($_SESSION['errors'])) {
                            $errors = $_SESSION['errors'];

                            foreach ($errors as $error) {
                            ?>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        <?php echo $error; ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }

                            unset($_SESSION['errors']);
                        }
                        ?>

                        <?php
                        if (isset($_SESSION['success'])) {
                            ?>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-primary">
                                        <?php echo $_SESSION['success']; ?>
                                    </div>
                                </div>
                            </div>
                            <?php

                            unset($_SESSION['success']);
                        }
                        ?>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="name">Enter Name:</label>
                                <input class="form-control" type="text" id="name" name="name" placeholder="John Doe" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <label for="email">Enter Email:</label>
                                <input class="form-control" type="email" id="email" name="email" placeholder="john@domain.com" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <label for="password">Enter Password:</label>
                                <input class="form-control" type="password" id="password" name="password" placeholder="Password"
                                       required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <label for="confirm_password">Confirm Password:</label>
                                <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Password"
                                       required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <label for="address">Enter Address:</label>
                                <input class="form-control" type="text" id="address" name="address" placeholder="Address" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <label for="mobile">Enter Mobile Number:</label>
                                <input class="form-control" type="number" id="mobile" name="mobile" placeholder="0701234567" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <label for="dob">Date of Birth:</label>
                                <input class="form-control" type="date" id="dob" name="dob" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <input class="btn btn-primary form-control" type="submit" id="login_submit"
                                       name="login_submit" value="Register">
                            </div>
                        </div>
                    </form>

                    <div class="row mt-5 mb-3 justify-content-center">
                        <div class="col-md-12">
                            <p class="text-center">Already have an account? <a href="/">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/js.php') ?>
<script>
    // This function is used to validate a form with the id 'reg_form'
    function validateForm() {
        $('#reg_form').validate({
            // Define validation rules for form fields
            rules: {
                name: {
                    required: true, // Name field is required
                },
                email: {
                    required: true, // Email field is required
                    email: true,    // Email must be in a valid email format
                },
                password: {
                    required: true,      // Password field is required
                    passwordCheck: true, // Custom password validation using the 'passwordCheck' method
                },
                confirm_password: {
                    required: true,         // Confirm password field is required
                    equalTo: "#password"   // Must match the value in the 'password' field
                },
                address: {
                    required: true,  // Address field is required
                    maxlength: 255   // Address must not exceed 255 characters
                },
                mobile: {
                    required: true,  // Mobile number field is required
                    maxlength: 10    // Mobile number must not exceed 10 characters
                },
                dob: {
                    required: true,  // Date of Birth field is required
                }
            },
            // Define custom error messages for each field
            messages: {
                name: {
                    required: "Name is required.",
                },
                email: {
                    required: "Email is required.",
                    email: "Please enter a valid email address."
                },
                password: {
                    required: "Password is required.",
                },
                confirm_password: {
                    required: "Re-entering the password is required.",
                    equalTo: "Your passwords do not match."
                },
                address: {
                    required: "Address is required.",
                    maxlength: "Number of characters in Address must be less than or equal to 255."
                },
                mobile: {
                    required: "Mobile Number is required.",
                    maxlength: "Number of characters in Mobile Number must be less than or equal to 10."
                },
                dob: {
                    required: "Date of Birth is required."
                }
            },
        });
    }

    $(document).ready(function () {
        // Define a custom validation method called 'passwordCheck' for the password field
        $.validator.addMethod("passwordCheck", function(value, element) {
            return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/.test(value);
        }, "Please enter a valid password (minimum 8 characters, at least 1 uppercase letter, 1 lowercase letter, and 1 number)");

        // Call the 'validateForm' function to set up form validation when the document is ready
        validateForm();
    });
</script>
</body>
</html>