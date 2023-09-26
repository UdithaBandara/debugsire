<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/">MED PRES</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
            </ul>

            <div class="d-flex">
                <?php
                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == '1') {
                    ?>
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user-circle" style="margin-right: 10px;"></i>
                                <?php echo $_SESSION['name']; ?>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item disabled"><?php echo $_SESSION['user_type']; ?></a>
                                <div class="dropdown-divider"></div>
                                <?php
                                if ($_SESSION["user_type"] == "User") {
                                    ?>
                                    <a class="dropdown-item"
                                       href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/'; ?>user_prescriptions"><i
                                            class="fas fa-list" style="margin-right: 10px;"></i> Prescriptions</a>

                                    <a class="dropdown-item"
                                       href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/'; ?>user_quotes"><i
                                            class="fas fa-money-bill" style="margin-right: 10px;"></i> Quotations</a>
                                    <?php
                                }
                                ?>
                                <?php
                                if ($_SESSION["user_type"] == "Pharmacy") {
                                    ?>
                                    <a class="dropdown-item"
                                       href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/'; ?>pharmacy_prescriptions"><i
                                            class="fas fa-list" style="margin-right: 10px;"></i> Prescriptions</a>
                                    <a class="dropdown-item"
                                       href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/'; ?>pharmacy_quotes"><i
                                                class="fas fa-money-bill" style="margin-right: 10px;"></i> Quotations</a>
                                    <?php
                                }
                                ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"
                                   href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/'; ?>logout"><i
                                        class="fas fa-sign-out-alt" style="margin-right: 10px;"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</nav>