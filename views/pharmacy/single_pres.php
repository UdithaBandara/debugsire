<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include('views/includes/css.php') ?>
    <title>Med Pres - Single Prescription</title>
</head>
<body>
<?php include('views/includes/navbar.php') ?>

<div class="container">
    <div class="row mt-5 mb-3">
        <div class="col-md-12">
            <h4><i class="fa fa-list" style="margin-right: 7px"></i> Single Prescription</h4>
        </div>
    </div>

    <hr>

    <div class="row mt-5 mb-3">
        <div class="col-md-12">
            <h5><b>Delivery Note:</b></h5>
            <p><?php print_r($prescriptions["note"]); ?></p>
        </div>
    </div>

    <hr>

    <div class="row mt-5 mb-3">
        <div class="col-md-5">
            <div class="slider img-container">
                <?php
                foreach ($prescriptions["images"] as $image) {
                    ?>
                    <img class="" src="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/' . $image["image"]; ?>" alt="image-1">
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="col-md-7">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped" id="table_pres">
                        <thead>
                        <tr>
                            <th>Drug</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody id="table_pres_body">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12 align-right">
                    <h4>Total: <span id="total_price">0.00</span></h4>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="drug">Drug:</label>
                    <input class="form-control" type="text" id="drug" name="drug" required>
                </div>
                <div class="col-md-4">
                    <label for="qty">Quantity:</label>
                    <input class="form-control" type="number" id="qty" name="qty" required>
                </div>
                <div class="col-md-4">
                    <label for="up">Unit Price:</label>
                    <input class="form-control" type="number" id="up" name="up" required>
                </div>
            </div>

            <div class="row mt-3 mb-2 justify-content-end">
                <div class="col-md-3">
                    <button id="btn_add_row" class="btn btn-sm btn-primary btn-full-width">ADD</button>
                </div>
            </div>

            <hr>

            <div class="row mt-3 justify-content-end">
                <div class="col-md-4">
                    <button id="send_quote" type="button" class="btn btn-primary btn-full-width">SEND QUOTATION</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('views/includes/js.php') ?>
<script>
    // Initialize a variable to store the total price of items
    let total_price = 0;

    // Initialize an array to store information about each row/item
    let rows = [];

    // Function to add a new row/item to the quotation table
    function addRow() {
        $('#btn_add_row').on('click', function () {
            // Get the drug name, quantity, and unit price from input fields
            let drug = $("#drug").val();
            let qty = parseFloat($("#qty").val());
            let unit_price = parseFloat($("#up").val());

            // Calculate the price for the current item
            let price = (qty * unit_price);

            // Update the total price by adding the current item's price
            total_price += price;

            // Create a table row HTML string with the item details
            let table_row = "<tr>"
                +"<td>" + drug + "</td>"
                +"<td class='align-right'>" + unit_price.toFixed(2) + "</td>"
                +"<td class='align-right'>" + qty.toFixed(2) + "</td>"
                +"<td class='align-right'>" + price.toFixed(2) + "</td>"
                +"</tr>";

            // Append the new row to the quotation table
            $("#table_pres_body").append(table_row);

            // Update the displayed total price
            $('#total_price').html(total_price.toFixed(2));

            // Create an object representing the current item and add it to the 'rows' array
            let drug_obj = {
                drug: drug,
                qty: qty,
                unit_price: unit_price,
                price: price
            }
            rows.push(drug_obj);

            // Clear the input fields for the next item
            $('#drug').val("");
            $('#qty').val("");
            $('#up').val("");
        });
    }

    // Function to send the quotation to the server
    function sendQuote() {
        $("#send_quote").on('click', function () {
            if (rows.length === 0) {
                // Show an error message if there are no items in the quotation
                Swal.fire(
                    'Error!',
                    'Quotation data cannot be empty.',
                    'error'
                );
            } else if (total_price === 0) {
                // Show an error message if the total price is zero
                Swal.fire(
                    'Error!',
                    'Total cannot be 0.',
                    'error'
                );
            } else {
                // Create an object with the total price and item details
                let quote_data = {
                    total: total_price,
                    rows: rows
                }

                // Send a POST request to save the quotation on the server
                $.post('/save_quote', {data: quote_data}, function (data, status) {
                    console.log(data);

                    if (data === "success") {
                        // If the request is successful, clear the table and reset variables
                        $("#table_pres_body").html("");
                        $('#total_price').html("0.00");
                        total_price = 0.0;
                        rows = [];

                        // Show a success message to the user
                        Swal.fire(
                            'Success!',
                            'Quotation was sent to the customer successfully.',
                            'success'
                        );
                    } else {
                        // Show an error message if the server request fails
                        Swal.fire(
                            'Error!',
                            'Something went wrong. Please try again in a moment.',
                            'error'
                        );
                    }
                });
            }
        });
    }

    // Run the following code when the document is ready
    $(document).ready(function(){
        // Initialize a slider using the bxSlider library
        $('.slider').bxSlider({
            autoControls: false,
            auto: false,
            pager: true,
            captions: false,
            speed: 1000
        });

        // Initialize the addRow and sendQuote functions
        addRow();
        sendQuote();
    });
</script>
</body>
</html>