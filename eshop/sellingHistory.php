<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Selling History | Admins | eShop</title>

    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css" />

    <link rel="icon" href="resources/logo.svg" />
</head>

<body style="background-color: #74EBD5;background-image: linear-gradient(90deg,#74EBD5 0%,#9FACE6 100%);">

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 bg-light text-center">
                <label class="form-label text-primary fw-bold fs-1">Selling History</label>
            </div>

            <div class="col-12 bg-light mt-3 mb-3">
                <div class="row">
                    <div class="col-12 col-lg-3 mt-3 mb-3">
                        <label class="form-label fs-5">Search by Invoice ID : </label>
                        <input type="text" class="form-control fs-5" id="searchtxt" 
                        onkeyup="searchinvoice();"/>
                    </div>
                    <div class="col-12 col-lg-2 mt-3 mb-3"></div>
                    <div class="col-12 col-lg-3 mt-3 mb-3">
                        <label class="form-label fs-5">From Date : </label>
                        <input type="date" id="from" class="form-control fs-5" />
                    </div>
                    <div class="col-12 col-lg-3 mt-3 mb-3">
                        <label class="form-label fs-5">To Date : </label>
                        <input type="date" id="to" class="form-control fs-5" />
                    </div>
                    <div class="col-12 col-lg-1 mt-3 mb-3 d-grid">
                        <button class="btn btn-primary fs-5 fw-bold" onclick="findSellings();">Find</button>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">

                    <div class="col-1 bg-secondary text-end">
                        <label class="form-label fs-5 fw-bold text-white">Invoice ID</label>
                    </div>
                    <div class="col-3 bg-body text-end">
                        <label class="form-label fs-5 fw-bold text-black">Product</label>
                    </div>
                    <div class="col-3 bg-secondary text-end">
                        <label class="form-label fs-5 fw-bold text-white">Buyer</label>
                    </div>
                    <div class="col-2 bg-body text-end">
                        <label class="form-label fs-5 fw-bold text-black">Amount</label>
                    </div>
                    <div class="col-1 bg-secondary text-end">
                        <label class="form-label fs-5 fw-bold text-white">Quantity</label>
                    </div>
                    <div class="col-2 bg-white"></div>

                </div>
            </div>

            <div class="col-12 mt-2" id="view_area">

                <?php

                include "connection.php";

                $query = "SELECT * FROM `invoice`";
                $pageno;

                if (isset($_GET["page"])) {
                    $pageno = $_GET["page"];
                } else {
                    $pageno = 1;
                }

                $invoice_rs = Database::search($query);
                $invoice_num = $invoice_rs->num_rows;

                $results_per_page = 5;
                $number_of_pages = ceil($invoice_num / $results_per_page);

                $page_results = ($pageno - 1) * $results_per_page;
                $selected_rs = Database::search($query . " LIMIT " . $results_per_page .
                    " OFFSET " . $page_results);

                $selected_num = $selected_rs->num_rows;

                for ($x = 0; $x < $selected_num; $x++) {
                    $selected_data = $selected_rs->fetch_assoc();

                    $user_rs = Database::search("SELECT * FROM `user` WHERE 
                `email`='" . $selected_data["user_email"] . "'");
                    $user_data = $user_rs->fetch_assoc();

                    $product_rs = Database::search("SELECT * FROM `product` WHERE 
                `id`='" . $selected_data["product_id"] . "'");
                    $product_data = $product_rs->fetch_assoc();


                ?>

                    <div class="row">

                        <div class="col-1 bg-secondary text-end">
                            <label class="form-label fs-5 fw-bold text-white mt-1 mb-1">
                                <?php echo $selected_data["invoice_id"]; ?></label>
                        </div>
                        <div class="col-3 bg-body text-end">
                            <label class="form-label fs-5 fw-bold text-black mt-1 mb-1">
                                <?php echo $product_data["title"]; ?></label>
                        </div>
                        <div class="col-3 bg-secondary text-end">
                            <label class="form-label fs-5 fw-bold text-white mt-1 mb-1">
                                <?php echo $user_data["fname"]." ".$user_data["lname"]; ?></label>
                        </div>
                        <div class="col-2 bg-body text-end">
                            <label class="form-label fs-5 fw-bold text-black mt-1 mb-1">
                                Rs.<?php echo $selected_data["total"]; ?>.00</label>
                        </div>
                        <div class="col-1 bg-secondary text-end">
                            <label class="form-label fs-5 fw-bold text-white mt-1 mb-1">
                            <?php echo $selected_data["invoice_qty"]; ?></label>
                        </div>
                        <div class="col-2 bg-white d-grid">
                            <?php
                            
                            if($selected_data["status"] == 0){
                                ?>
                                <button class="btn btn-success fw-bold mt-1 mb-1">Confirm Order</button>
                                <?php
                            }else if($selected_data["status"] == 1){
                                ?>
                                <button class="btn btn-warning fw-bold mt-1 mb-1">Packing</button>
                                <?php
                            }else if($selected_data["status"] == 2){
                                ?>
                                <button class="btn btn-primary fw-bold mt-1 mb-1">Dispatched</button>
                                <?php
                            }else if($selected_data["status"] == 3){
                                ?>
                                <button class="btn btn-info fw-bold mt-1 mb-1">Shipping</button>
                                <?php
                            }else if($selected_data["status"] == 4){
                                ?>
                                <button class="btn btn-secondary fw-bold mt-1 mb-1">Delivered</button>
                                <?php
                            }

                            ?>
                            
                        </div>

                    </div>

                <?php
                }

                ?>



                <!--  -->
                <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3 mt-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-lg justify-content-center">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!--  -->
            </div>

        </div>
    </div>

    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/script.js"></script>
</body>

</html>