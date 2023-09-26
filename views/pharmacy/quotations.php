<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include('views/includes/css.php') ?>
    <title>Med Pres - Quotations</title>
</head>
<body>
<?php include('views/includes/navbar.php') ?>

<div class="container">
    <div class="row mt-5 mb-3">
        <div class="col-md-12">
            <h4><i class="fas fa-money-bill" style="margin-right: 7px"></i> Quotations</h4>
        </div>
    </div>

    <hr>

    <div class="row mt-3 mb-3">
        <div class="col-md-12">
            <table class="table table-striped" id="table_quotes">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Total</th>
                    <th>Prescription</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($quotes as $quote) {
                    ?>
                    <tr>
                        <td><?php print_r($quote["id"]); ?></td>
                        <td><?php print_r(round($quote["total"], 2)); ?></td>
                        <td><?php print_r($quote["pres"]); ?></td>
                        <td><?php print_r($quote["status"]); ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('views/includes/js.php') ?>
<script>
    // Wait for the document to be fully loaded before executing any code
    $(document).ready(function () {
        // Initialize DataTables plugin for the HTML table with the ID 'table_quotes'
        $('#table_quotes').DataTable();
    });
</script>
</body>
</html>