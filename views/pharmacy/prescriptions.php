<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include('views/includes/css.php') ?>
    <title>Med Pres - Client Prescriptions</title>
</head>
<body>
<?php include('views/includes/navbar.php') ?>

<div class="container">
    <div class="row mt-5 mb-3">
        <div class="col-md-12">
            <h4><i class="fa fa-list" style="margin-right: 7px"></i> Client Prescriptions</h4>
        </div>
    </div>

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
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
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
                                <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/' . $image["image"]; ?>" data-lightbox="gallery">
                                    <div class="pres-image-container">
                                        <img class="img-thumbnail pres-image" src="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/' . $image["image"]; ?>" alt="image-1">
                                    </div>
                                </a>
                                <?php
                            }
                            ?>
                        </td>
                        <td>
                            <a target="_blank" href="/single_pres/<?php print_r($prescription["id"]); ?>">
                                <button class="btn btn-primary btn-sm">OPEN</button>
                            </a>
                        </td>
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
        // Initialize DataTables plugin for the HTML table with the ID 'table_pres'
        $('#table_pres').DataTable();
    });
</script>
</body>
</html>