<?php

include "connection.php";

if (isset($_GET["id"])) {
    $iid = $_GET["id"];

    $invoice_rs = Database::search("SELECT * FROM `invoice` 
    WHERE `invoice_id`='" . $iid . "'");
    $invoice_num = $invoice_rs->num_rows;

    if ($invoice_num == 1) {
        $selected_data = $invoice_rs->fetch_assoc();

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
                    <?php echo $selected_data["invoice_id"]; ?>
                </label>
            </div>
            <div class="col-3 bg-body text-end">
                <label class="form-label fs-5 fw-bold text-black mt-1 mb-1">
                    <?php echo $product_data["title"]; ?></label>
            </div>
            <div class="col-3 bg-secondary text-end">
                <label class="form-label fs-5 fw-bold text-white mt-1 mb-1">
                    <?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></label>
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

                if ($selected_data["status"] == 0) {
                ?>
                    <button class="btn btn-success fw-bold mt-1 mb-1" onclick="changeStatus(1);">Confirm Order</button>
                <?php
                } else if ($selected_data["status"] == 1) {
                ?>
                    <button class="btn btn-warning fw-bold mt-1 mb-1" onclick="changeStatus(2);">Packing</button>
                <?php
                } else if ($selected_data["status"] == 2) {
                ?>
                    <button class="btn btn-primary fw-bold mt-1 mb-1" onclick="changeStatus(3);">Dispatched</button>
                <?php
                } else if ($selected_data["status"] == 3) {
                ?>
                    <button class="btn btn-info fw-bold mt-1 mb-1" onclick="changeStatus(4);">Shipping</button>
                <?php
                } else if ($selected_data["status"] == 4) {
                ?>
                    <button class="btn btn-secondary fw-bold mt-1 mb-1" disabled>Delivered</button>
                <?php
                }

                ?>

            </div>

        </div>

<?php

    } else {
        echo ("Invalid invoice ID.");
    }
} else {
    echo ("Please add an invoice number first");
}

?>