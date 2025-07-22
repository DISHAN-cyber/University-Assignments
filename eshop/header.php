<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />

</head>

<body>

    <div class="col-12">
        <div class="row mt-1 mb-1">

            <div class="offset-lg-1 col-12 col-lg-3 align-self-start mt-2">

                <?php
                session_start();

                if (isset($_SESSION["u"])) {
                    $data = $_SESSION["u"];

                ?>
                    <span class="text-lg-start text-success"><b>Hi, </b><?php echo $data["fname"]; ?></span> |
                    <span class="text-lg-start fw-bold signout" onclick="signout();">Signout</span>
                <?php
                
                } else {

                ?>
                    <a href="index.php" class="text-decoration-none fw-bold">Sign In or Register</a>

                <?php
                
                }

                ?>

                <a href="index.php" class="text-decoration-none fw-bold">Sign In or Register</a> |
                <span class="text-lg-start fw-bold">Help and Contact</span>

            </div>

            <div class="col-12 col-lg-3 offset-lg-5 align-self-end" style="text-align: center;">
                <div class="row">

                    <div class="col-1 col-lg-3 mt-2">
                        <span class="text-start fw-bold">Sell</span>
                    </div>

                    <div class="col-12 col-lg-6 dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            My eShop
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="userProfile.php">My Profile</a></li>
                            <li><a class="dropdown-item" href="#">My Sellings</a></li>
                            <li><a class="dropdown-item" href="myProducts.php">My Products</a></li>
                            <li><a class="dropdown-item" href="watchlist.php">Watchlist</a></li>
                            <li><a class="dropdown-item" href="purchasingHistory.php">Purchase History</a></li>
                            <li><a class="dropdown-item" href="messages.php">Messages</a></li>
                            <li><a class="dropdown-item" href="#" onclick="contactAdmin();">Contact Admin</a></li>
                        </ul>
                    </div>

                    <a href="cart.php" class="col-1 col-lg-3 ms-5 ms-lg-0 mt-1 cart-icon"></a>

                    <!-- msg modal -->
                    <div class="modal" tabindex="-1" id="contactAdmin">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Contact Admin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body overflow-scroll">

                                    <?php

                                    include "connection.php";

                                    $mail = $_SESSION["u"]["email"];

                                    $msg_rs = Database::search("SELECT * FROM `admin_chat` WHERE
                                    `from`='" . $mail . "' OR `to`='" . $mail . "'");

                                    $msg_num = $msg_rs->num_rows;

                                    for ($x = 0; $x < $msg_num; $x++) {
                                        $msg_data = $msg_rs->fetch_assoc();
                                        $from = $msg_data["from"];
                                        $to = $msg_data["to"];

                                        if ($from == $mail) {
                                    ?>
                                            <!-- sent -->
                                            <div class="col-12 mt-2">
                                                <div class="row">
                                                    <div class="offset-4 col-8 rounded bg-primary">
                                                        <div class="row">
                                                            <div class="col-12 pt-2">
                                                                <span class="text-white fw-bold fs-4"><?php echo $msg_data["msg"];?></span>
                                                            </div>
                                                            <div class="col-12 text-end pb-2">
                                                                <span class="text-white fs-6"><?php echo $msg_data["msg_date"];?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- sent -->
                                        <?php
                                        } else if ($to == $mail) {
                                        ?>
                                            <!-- received -->
                                            <div class="col-12 mt-2">
                                                <div class="row">
                                                    <div class="col-8 rounded bg-success">
                                                        <div class="row">
                                                            <div class="col-12 pt-2">
                                                                <span class="text-white fw-bold fs-4"><?php echo $msg_data["msg"];?></span>
                                                            </div>
                                                            <div class="col-12 text-end pb-2">
                                                                <span class="text-white fs-6"><?php echo $msg_data["msg_date"]?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- received -->
                                    <?php
                                        }
                                    }
                                    ?>

                                </div>
                                <div class="modal-footer">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="msgtxt" />
                                            </div>
                                            <div class="col-3 d-grid">
                                                <button type="button" class="btn btn-primary" onclick="adminChat();">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->

                </div>
            </div>

        </div>
    </div>


    <script src="js/script.js"></script>
</body>

</html>