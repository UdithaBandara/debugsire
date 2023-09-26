<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include('includes/css.php') ?>
    <title>Med Pres - Login</title>
</head>
<body>
<?php include('includes/navbar.php') ?>

<div class="container">
    <div class="row mt-5 justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center">Login</h3>
                        </div>
                    </div>

                    <form action="/login_action" method="post" id="login_form">
                        <?php
                        if (isset($_SESSION['error'])) {
                            ?>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        <?php echo $_SESSION['error']; ?>
                                    </div>
                                </div>
                            </div>
                            <?php

                            unset($_SESSION['error']);
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
                                <label for="email">Enter Email:</label>
                                <input class="form-control" type="email" id="email" name="email" placeholder="john@domain.com" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <label for="password">Enter Password:</label>
                                <input class="form-control" type="password" id="password" name="password" placeholder="*************"
                                       required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <input class="btn btn-primary form-control" type="submit" id="login_submit"
                                       name="login_submit" value="Login">
                            </div>
                        </div>
                    </form>

                    <div class="row mt-5 mb-3 justify-content-center">
                        <div class="col-md-12">
                            <p class="text-center">Don't have an account? <a href="/register">Register</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('includes/js.php') ?>
<script>
    // This function is used to set up form validation using the jQuery Validation plugin.
    function validateForm() {
        $('#login_form').validate({
            // Define rules for form fields.
            rules: {
                email: {
                    required: true,  // Email field is required.
                    email: true,    // Must be a valid email address format.
                },
                password: {
                    required: true   // Password field is required.
                }
            },
            // Define custom error messages for form fields.
            messages: {
                email: {
                    required: "Email is required.",  // Error message for a missing email.
                    email: "Please enter a valid email address."  // Error message for an invalid email format.
                },
                password: {
                    required: "Password is required."  // Error message for a missing password.
                }
            },
        });
    }

    // This code ensures that the form validation is set up when the document is ready.
    $(document).ready(function () {
        validateForm();  // Call the validateForm() function to set up form validation.
    });
</script>
</body>
</html>