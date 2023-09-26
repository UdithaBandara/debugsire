<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include('views/includes/css.php') ?>
    <title>Med Pres - My Prescriptions</title>
</head>
<body>
<?php include('views/includes/navbar.php') ?>

<div class="container">
    <div class="row mt-5 mb-3">
        <div class="col-md-10">
            <h4><i class="fa fa-list" style="margin-right: 7px"></i> My Prescriptions</h4>
        </div>
        <div class="col-md-2">
            <button id="btn_add" class="btn btn-primary btn-sm btn-full-width">ADD PRESCRIPTION</button>
        </div>
    </div>

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

    <hr>

    <div class="row mt-3 mb-5">
        <div class="col-md-12">
            <table class="table table-striped" id="table_pres">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Address</th>
                    <th>Time</th>
                    <th>Note</th>
                    <th>Images</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($prescriptions != null) {
                    foreach ($prescriptions as $prescription) {
                        ?>
                        <tr>
                            <td><?php print_r($prescription["id"]); ?></td>
                            <td><?php print_r($prescription["delivery_address"]); ?></td>
                            <td><?php print_r($prescription["delivery_time"]); ?></td>
                            <td><?php print_r($prescription["note"]); ?></td>
                            <td>
                                <?php
                                $images = $prescription["images"];

                                foreach ($images as $image) {
                                    ?>
                                    <a class="demo" href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/' . $image["image"]; ?>" data-lightbox="gallery">
                                        <div class="pres-image-container">
                                            <img class="img-thumbnail pres-image" src="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/' . $image["image"]; ?>" alt="image-1">
                                        </div>
                                    </a>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="add_modal" class="modal fade">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row mt-2 mb-3">
                    <div class="col-md-10">
                        <h4><i class="fa fa-list" style="margin-right: 7px"></i> Add New Prescriptions</h4>
                    </div>
                </div>

                <hr>

                <form action="/save_prescriptions" enctype="multipart/form-data" id="pres_form" method="post">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="address">Delivery Address:</label>
                            <input class="form-control" type="text" id="address" name="address" placeholder="Address" required>
                        </div>

                        <div class="col-md-4">
                            <label for="time">Delivery Time:</label>
                            <input class="form-control" type="time" id="time" name="time" placeholder="Time" required>
                        </div>

                        <div class="col-md-4">
                            <label for="images">Prescription Images:</label>
                            <input class="form-control" type="file" id="images" name="images[]" placeholder="Images" accept="image/jpeg, image/png" multiple required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="note">Delivery Images:</label>
                            <textarea name="note" id="note" cols="30" rows="5" class="form-control" maxlength="2000" required></textarea>
                        </div>
                    </div>

                    <div class="row mt-3 justify-content-end">
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-full-width">SAVE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('views/includes/js.php') ?>
<script>
    // This function is used to set up form validation using the jQuery Validation plugin.
    function validateForm() {
        $('#pres_form').validate({
            rules: {
                // Define validation rules for the 'address' field.
                address: {
                    required: true, // Address field is required.
                    maxlength: 255  // Address field should have a maximum length of 255 characters.
                },
                // Define validation rules for the 'time' field.
                time: {
                    required: true  // Time field is required.
                },
                // Define validation rules for the 'images[]' field, which is typically used for file uploads.
                "images[]": {
                    required: true,  // At least one image is required.
                    maxupload: function(element) {
                        return true; // Custom validation function allowing a maximum of 5 uploaded images.
                    }
                },
                // Define validation rules for the 'note' field.
                note: {
                    required: true,  // Note field is required.
                    maxlength: 2000  // Note field should have a maximum length of 2000 characters.
                }
            },
            messages: {
                // Define custom error messages for each field when validation fails.
                address: {
                    required: "Delivery Address is required.",
                    maxlength: "Character length of Delivery Address must be less than or equal to 255."
                },
                time: {
                    required: "Delivery Time is required."
                },
                "images[]": {
                    required: "Select at least 1 image to upload."
                },
                note: {
                    required: "Delivery Note is required.",
                    maxlength: "Character length of Delivery Note must be less than or equal to 2000."
                }
            },
        });
    }

    // This function is used to open a modal dialog when a button with the id 'btn_add' is clicked.
    function openAddModal() {
        $('#btn_add').on('click', function () {
            $('#add_modal').modal('toggle'); // Toggle the visibility of the 'add_modal' dialog.
        });
    }

    $(document).ready(function () {
        // Define a custom validation method 'maxupload' for file uploads, allowing a maximum of 5 files.
        $.validator.addMethod('maxupload', function (value, element) {
            let length = element.files.length;
            return this.optional(element) || length <= 5;
        }, "You can only upload a maximum of 5 images.");

        // Initialize a DataTable with the id 'table_pres'.
        $('#table_pres').DataTable();

        // Attach the 'openAddModal' and 'validateForm' functions to the document ready event.
        openAddModal();  // Open the modal dialog when the 'btn_add' button is clicked.
        validateForm();  // Set up form validation using the specified rules and messages.
    });
</script>
</body>
</html>