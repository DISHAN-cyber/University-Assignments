<?php

session_start();

include "connection.php";

if (isset($_SESSION["au"])) {
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Admin Panel | eShop</title>

        <link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="css/style.css" />

        <link rel="icon" href="resources/logo.svg" />
    </head>

    <body style="background-color: #74EBD5;background-image: linear-gradient(90deg,#74EBD5 0%,#9FACE6 100%);">

        <div class="container-fluid">
            <div class="row">

                <div class="col-12 col-lg-2">
                    <div class="row">
                        <div class="col-12 align-items-start bg-dark vh-100">
                            <div class="row g-1 text-center">

                                <div class="col-12 mt-5">
                                    <h4 class="text-white"><?php echo $_SESSION["au"]["fname"] . " " . $_SESSION["au"]["lname"]; ?></h4>
                                    <hr class="border border-1 border-white" />
                                </div>
                                <div class="nav flex-column nav-pills me-3 mt-3" role="tablist" aria-orientation="vertical">
                                    <nav class="nav flex-column">
                                        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                                        <a class="nav-link" href="manageUsers.php">Manage Users</a>
                                        <a class="nav-link" href="manageProduct.php">Manage Products</a>
                                    </nav>
                                </div>
                                <div class="col-12 mt-5">
                                    <hr class="border border-1 border-white" />
                                    <h4 class="text-white fw-bold">Selling History</h4>
                                    <hr class="border border-1 border-white" />
                                </div>
                                <div class="col-12 mt-3 d-grid">
                                    <label class="form-label fs-6 fw-bold text-white">From Date</label>
                                    <input type="date" class="form-control" />
                                    <label class="form-label fs-6 fw-bold text-white mt-2">To Date</label>
                                    <input type="date" class="form-control" />
                                    <a href="#" class="btn btn-primary mt-2">Search</a>
                                    <hr class="border border-1 border-white" />
                                    <label class="form-label fs-6 fw-bold text-white">Daily Sellings</label>
                                    <hr class="border border-1 border-white" />
                                    <hr class="border border-1 border-white" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-10">
                    <div class="row">

                        <div class="text-white fw-bold mb-1 mt-3">
                            <h2 class="fw-bold">Dashboard</h2>
                        </div>
                        <div class="col-12">
                            <hr />
                        </div>
                        <div class="col-12">
                            <div class="row g-1">

                                <div class="col-6 col-lg-4 px-1 shadow">
                                    <div class="row g-1">
                                        <div class="col-12 bg-primary text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Daily Earnings</span>
                                            <br />
                                            <?php

                                            $today = date("Y-m-d");
                                            $thisMonth = date("m");
                                            $thisYear = date("Y");

                                            $a = "0";
                                            $b = "0";
                                            $c = "0";
                                            $e = "0";
                                            $f = "0";

                                            $invoice_rs = Database::search("SELECT * FROM `invoice`");
                                            $invoice_num = $invoice_rs->num_rows;

                                            for ($x = 0; $x < $invoice_num; $x++) {
                                                $invoice_data = $invoice_rs->fetch_assoc();

                                                $f = $f + $invoice_data["invoice_qty"]; //total qty

                                                $d = $invoice_data["date"];
                                                $splitDate = explode(" ", $d); //separate date from time
                                                $pdate = $splitDate[0]; //sold date

                                                if ($pdate == $today) {

                                                    $a = $a + $invoice_data["total"]; //today income
                                                    $c = $c + $invoice_data["invoice_qty"]; //today sold qty

                                                }

                                                $splitMonth = explode("-", $pdate); //separate date as year, mont and date
                                                $pMonth = $splitMonth[1]; //sold month
                                                $pYear = $splitMonth[0]; //sold year

                                                if ($pYear == $thisYear) {
                                                    if ($pMonth == $thisMonth) {
                                                        $b = $b + $invoice_data["total"]; //monthly income
                                                        $e = $e + $invoice_data["invoice_qty"]; //monthly sold qty
                                                    }
                                                }
                                            }
                                            ?>

                                            <span class="fs-5">Rs. <?php echo $a; ?> .00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-white text-black text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Monthly Earnings</span>
                                            <br />

                                            <span class="fs-5">Rs. <?php echo $b; ?> .00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-dark text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Today Sellings</span>
                                            <br />
                                            <span class="fs-5"><?php echo $c; ?> Items</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-secondary text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Monthly Sellings</span>
                                            <br />
                                            <span class="fs-5"><?php echo $e; ?> Items</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-success text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Total Sellings</span>
                                            <br />
                                            <span class="fs-5"><?php echo $f; ?> Items</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1 shadow">
                                    <div class="row g-1">
                                        <div class="col-12 bg-danger text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Total Engagements</span>
                                            <br />

                                            <?php

                                            $user_rs = Database::search("SELECT * FROM `user`");
                                            $user_num = $user_rs->num_rows;

                                            ?>

                                            <span class="fs-5"><?php echo $user_num; ?> Members</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-12">
                            <hr />
                        </div>

                        <div class="col-12 bg-dark">
                            <div class="row">
                                <div class="col-12 col-lg-2 text-center my-3">
                                    <label class="form-label fs-4 fw-bold text-white">Total Active Time</label>
                                </div>
                                <div class="col-12 col-lg-10 text-center my-3">

                                    <label class="form-label fs-4 fw-bold text-warning">
                                        <?php

                                        $start_date = new DateTime("2024-07-09 14:00:00");

                                        $date = new DateTime();
                                        $tz = new DateTimeZone("Asia/Colombo");
                                        $date->setTimezone($tz);
                                        $end_date = new DateTime($date->format("Y-m-d H:i:s"));

                                        $difference = $end_date->diff($start_date);

                                        echo $difference->format("%Y") . " Years " . $difference->format("%m") . " Months "
                                            . $difference->format("%d") . " Days " . $difference->format("%H") . " Hours "
                                            . $difference->format("%i") . " Minutes " . $difference->format("%s") . " Seconds ";

                                        ?>

                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="offset-1 col-10 col-lg-4 my-3 rounded bg-body">
                            <div class="row g-1">
                                <div class="col-12 text-center">
                                    <label class="form-label fs-4 fw-bold text-decoration-underline">Mostly Sold Item</label>
                                </div>

                                <?php

                                $freq_rs = Database::search("SELECT `product_id`,COUNT(`product_id`) AS `value_occurence`
                                FROM `invoice` WHERE `date` LIKE '%" . $today . "%' GROUP BY `product_id` ORDER BY 
                                `value_occurence` DESC LIMIT 1");

                                $freq_num = $freq_rs->num_rows;

                                if ($freq_num == 1) {
                                    $freq_data = $freq_rs->fetch_assoc();
                                    $pid = $freq_data["product_id"];

                                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "'");
                                    $product_data = $product_rs->fetch_assoc();

                                    $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $pid . "'");
                                    $img_data = $img_rs->fetch_assoc();

                                    $pqty = $freq_data["value_occurence"];

                                ?>

                                    <div class="col-12 text-center shadow">
                                        <img src="<?php echo $img_data["img_path"]; ?>" class="img-fluid rounded-top" style="height: 250px;" />
                                    </div>
                                    <div class="col-12 text-center my-3">
                                        <span class="fs-5 fw-bold"><?php echo $product_data["title"]; ?></span><br />
                                        <span class="fs-6"><?php echo $product_data["qty"]; ?> items</span><br />
                                        <span class="fs-6">Rs. <?php echo $product_data["price"] * $pqty; ?> .00</span>
                                    </div>

                                <?php

                                } else {
                                ?>

                                    <!-- empty product -->
                                    <div class="col-12 text-center shadow">
                                        <img src="resources/empty.svg" class="img-fluid rounded-top" style="height: 250px;" />
                                    </div>
                                    <div class="col-12 text-center my-3">
                                        <span class="fs-5 fw-bold">-----</span><br />
                                        <span class="fs-6">--- items</span><br />
                                        <span class="fs-6">Rs. ----- .00</span>
                                    </div>
                                    <!-- empty product -->

                                <?php
                                }

                                ?>


                                <div class="col-12">
                                    <div class="first-place"></div>
                                </div>
                            </div>
                        </div>

                        <div class="offset-1 col-10 col-lg-4 my-3 rounded bg-body">
                            <div class="row g-1">

                                <?php

                                if ($freq_num == 1) {
                                    $user_rs1 = Database::search("SELECT * FROM `user` WHERE 
                                `email`='" . $product_data["user_email"] . "'");
                                    $user_data1 = $user_rs1->fetch_assoc();

                                    $profile_rs = Database::search("SELECT * FROM `profile_img` WHERE 
                                `user_email`='" . $product_data["user_email"] . "'");
                                    $profile_data = $profile_rs->fetch_assoc();

                                ?>

                                    <div class="col-12 text-center">
                                        <label class="form-label fs-4 fw-bold text-decoration-underline">Most Famous Seller</label>
                                    </div>
                                    <div class="col-12 text-center shadow">
                                        <?php

                                        if (isset($profile_data["img_path"])) {
                                        ?>
                                            <img src="<?php echo $profile_data["img_path"]; ?>" class="img-fluid rounded-top" style="height: 250px;" />
                                        <?php
                                        } else {
                                        ?>
                                            <img src="resources/new_user.svg" class="img-fluid rounded-top" style="height: 250px;" />
                                        <?php
                                        }

                                        ?>

                                    </div>
                                    <div class="col-12 text-center my-3">
                                        <span class="fs-5 fw-bold"><?php echo $user_data1["fname"] . " " . $user_data1["lname"]; ?></span><br />
                                        <span class="fs-6"><?php echo $user_data1["email"]; ?></span><br />
                                        <span class="fs-6"><?php echo $user_data1["mobile"]; ?></span>
                                    </div>

                                <?php

                                } else {
                                ?>

                                    <!-- empty user -->
                                    <div class="col-12 text-center">
                                        <label class="form-label fs-4 fw-bold text-decoration-underline">Most Famouse Seller</label>
                                    </div>
                                    <div class="col-12 text-center shadow">
                                        <img src="resources/new_user.svg" class="img-fluid rounded-top" style="height: 250px;" />
                                    </div>
                                    <div class="col-12 text-center my-3">
                                        <span class="fs-5 fw-bold">----- -----</span><br />
                                        <span class="fs-6">-----</span><br />
                                        <span class="fs-6">----------</span>
                                    </div>
                                    <!-- empty user -->


                                <?php
                                }

                                ?>



                                <div class="col-12">
                                    <div class="first-place"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <script src="js/bootstrap.bundle.js"></script>
        <script src="js/script.js"></script>
    </body>

    </html>


<?php
} else {
    header("Location:adminSignin.php");
}

?>