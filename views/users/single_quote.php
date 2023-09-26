<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include('views/includes/css.php') ?>
    <title>Med Pres - Single Quotation</title>
</head>
<body>
<?php include('views/includes/navbar.php') ?>

<div class="container">
    <div class="row mt-5 mb-3">
        <div class="col-md-12">
            <h4><i class="fas fa-money-bill" style="margin-right: 7px"></i> Single Quotation</h4>
        </div>
    </div>

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

    <div class="row mt-3">
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
                <tbody>
                <?php
                foreach ($quote_items as $quote_item) {
                    ?>
                    <tr>
                        <td><?php print_r($quote_item["drug"]) ?></td>
                        <td><?php print_r(number_format((float)$quote_item["unit_price"], 2, '.', '')) ?></td>
                        <td><?php print_r(number_format((float)$quote_item["qty"], 2, '.', '')) ?></td>
                        <td><?php print_r(number_format((float)$quote_item["price"], 2, '.', '')) ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-3 mb-2">
        <div class="col-md-12 align-right">
            <h4>Total: <span id="total_price"><?php print_r(number_format((float)$quote[0]["total"], 2, '.', '')) ?></span></h4>
        </div>
    </div>

    <?php
    if ($status == "Pending") {
    ?>
    <hr>

    <div class="row mt-4">
        <div class="col-md-12">
            <h4 class="text-center">Accept or Decline the quotation.</h4>
        </div>
    </div>

    <div class="row mt-4 justify-content-center">
        <div class="col-md-2">
            <a href="/change_status/<?php print_r($quote[0]["id"]) ?>/Declined" class="btn btn-danger btn-full-width">DECLINE</a>
        </div>
        <div class="col-md-2">
            <a href="/change_status/<?php print_r($quote[0]["id"]) ?>/Accepted" class="btn btn-success btn-full-width">ACCEPT</a>
        </div>
    </div>
    <?php }?>
</div>

<?php include('views/includes/js.php') ?>
</body>
</html>