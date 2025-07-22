<?php


include "connection.php";

$search_txt = $_POST["t"];
$category = $_POST["cat"];
$brand = $_POST["b"];
$model = $_POST["m"];
$condition = $_POST["con"];
$color = $_POST["col"];
$from = $_POST["pf"];
$to = $_POST["pt"];
$sort = $_POST["s"];

$query = "SELECT * FROM `product` ";
$status = 0;

if ($sort == 0) {

    if (!empty($search_txt)) {
        $query .= "WHERE `title` LIKE '%" . $search_txt . "%'";
        $status = 1;
    }

    if ($category != 0 && $status == 0) {
        $query .= "WHERE `category_cat_id`='" . $category . "'";
    } else if ($category != 0 && $status != 0) {
        $query .= " AND `category_cat_id`='" . $category . "'";
    }

    $pid = 0;

    if ($brand != 0 && $model == 0) {
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE
        `brand_id`='" . $brand . "'");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }
        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "'";
        }
    }
    if ($brand == 0 && $model != 0) {
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE
        `model_id`='" . $model . "'");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }

        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "'";
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "'";
        }
    }

    if ($brand != 0 && $model != 0){
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE 
        `brand_id`='" . $brand . "' AND `model_id`='" . $model . "'");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }
        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "'";
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "'";
        }

    }

    if($condition !=0 && $status == 0){
        $query .= "WHERE `condition_condition_id`='".$condition."'";
        $status = 1;
    }else if($condition != 0 && $status != 0){
        $query .= " AND `condition_condition_id`='".$condition."'";
    }

    if($color != 0 && $status == 0){
        $query .= "WHERE `color_clr_id`='".$color."'";
        $status = 1;
    }else if($color != 0 && $status != 0){
        $query .= " AND `color_clr_id`='".$color."'";
    }

    if(!empty($from) && empty($to)){
        if($status == 0){
            $query .= "WHERE `price`>= '".$from."'";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price`>='".$from."'";
        }
    }
    
    if(empty($from) && !empty($to)){
        if($status == 0){
            $query .= "WHERE `price`>= '".$to."'";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price`>='".$to."'";
        }
    }

    if(!empty($from) && !empty($to)){
        if($status == 0){
            $query .= "WHERE `price` BETWEEN '".$from."' AND '".$to."'";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price` BETWEEN '".$from."' AND '".$to."'";
        }
    }


} else if ($sort == 1) {
    //price low 2 high
    if (!empty($search_txt)) {
        $query .= "WHERE `title` LIKE '%" . $search_txt . "%' ORDER BY `price` ASC";
        $status = 1;
    }

    if ($category != 0 && $status == 0) {
        $query .= "WHERE `category_cat_id`='" . $category . "' ORDER BY `price` ASC";
    } else if ($category != 0 && $status != 0) {
        $query .= " AND `category_cat_id`='" . $category . "' ORDER BY `price` ASC";
    }

    $pid = 0;

    if ($brand != 0 && $model == 0) {
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE
        `brand_id`='" . $brand . "' ORDER BY `price` ASC");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }
        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `price` ASC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `price` ASC";
        }
    }
    if ($brand == 0 && $model != 0) {
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE
        `model_id`='" . $model . "' ORDER BY `price` ASC");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }

        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `price` ASC";
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `price` ASC";
        }
    }

    if ($brand != 0 && $model != 0){
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE 
        `brand_id`='" . $brand . "' AND `model_id`='" . $model . "' ORDER BY `price` ASC");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }
        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `price` ASC";
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `price` ASC";
        }

    }

    if($condition !=0 && $status == 0){
        $query .= "WHERE `condition_condition_id`='".$condition."' ORDER BY `price` ASC";
        $status = 1;
    }else if($condition != 0 && $status != 0){
        $query .= " AND `condition_condition_id`='".$condition."' ORDER BY `price` ASC";
    }

    if($color != 0 && $status == 0){
        $query .= "WHERE `color_clr_id`='".$color."' ORDER BY `price` ASC";
        $status = 1;
    }else if($color != 0 && $status != 0){
        $query .= " AND `color_clr_id`='".$color."' ORDER BY `price` ASC";
    }

    if(!empty($from) && empty($to)){
        if($status == 0){
            $query .= "WHERE `price`>= '".$from."' ORDER BY `price` ASC";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price`>='".$from."' ORDER BY `price` ASC";
        }
    }
    
    if(empty($from) && !empty($to)){
        if($status == 0){
            $query .= "WHERE `price`>= '".$to."' ORDER BY `price` ASC";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price`>='".$to."' ORDER BY `price` ASC";
        }
    }

    if(!empty($from) && !empty($to)){
        if($status == 0){
            $query .= "WHERE `price` BETWEEN '".$from."' AND '".$to."' ORDER BY `price` ASC";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price` BETWEEN '".$from."' AND '".$to."' ORDER BY `price` ASC";
        }
    }

} else if ($sort == 2) {
    //price high 2 low
    if (!empty($search_txt)) {
        $query .= "WHERE `title` LIKE '%" . $search_txt . "%' ORDER BY `price` DESC";
        $status = 1;
    }

    if ($category != 0 && $status == 0) {
        $query .= "WHERE `category_cat_id`='" . $category . "' ORDER BY `price` DESC";
    } else if ($category != 0 && $status != 0) {
        $query .= " AND `category_cat_id`='" . $category . "' ORDER BY `price` DESC";
    }

    $pid = 0;

    if ($brand != 0 && $model == 0) {
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE
        `brand_id`='" . $brand . "' ORDER BY `price` DESC");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }
        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `price` DESC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `price` DESC";
        }
    }
    if ($brand == 0 && $model != 0) {
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE
        `model_id`='" . $model . "' ORDER BY `price` DESC");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }

        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `price` DESC";
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `price` DESC";
        }
    }

    if ($brand != 0 && $model != 0){
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE 
        `brand_id`='" . $brand . "' AND `model_id`='" . $model . "' ORDER BY `price` DESC");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }
        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `price` DESC";
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `price` DESC";
        }

    }

    if($condition !=0 && $status == 0){
        $query .= "WHERE `condition_condition_id`='".$condition."' ORDER BY `price` DESC";
        $status = 1;
    }else if($condition != 0 && $status != 0){
        $query .= " AND `condition_condition_id`='".$condition."' ORDER BY `price` DESC";
    }

    if($color != 0 && $status == 0){
        $query .= "WHERE `color_clr_id`='".$color."' ORDER BY `price` DESC";
        $status = 1;
    }else if($color != 0 && $status != 0){
        $query .= " AND `color_clr_id`='".$color."' ORDER BY `price` DESC";
    }

    if(!empty($from) && empty($to)){
        if($status == 0){
            $query .= "WHERE `price`>= '".$from."' ORDER BY `price` DESC";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price`>='".$from."' ORDER BY `price` DESC";
        }
    }
    
    if(empty($from) && !empty($to)){
        if($status == 0){
            $query .= "WHERE `price`>= '".$to."' ORDER BY `price` DESC";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price`>='".$to."' ORDER BY `price` DESC";
        }
    }

    if(!empty($from) && !empty($to)){
        if($status == 0){
            $query .= "WHERE `price` BETWEEN '".$from."' AND '".$to."' ORDER BY `price` DESC";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price` BETWEEN '".$from."' AND '".$to."' ORDER BY `price` DESC";
        }
    }
} else if ($sort == 3) {
    //quantity l 2 h   
    if (!empty($search_txt)) {
        $query .= "WHERE `title` LIKE '%" . $search_txt . "%' ORDER BY `qty` ASC";
        $status = 1;
    }

    if ($category != 0 && $status == 0) {
        $query .= "WHERE `category_cat_id`='" . $category . "' ORDER BY `qty` ASC";
    } else if ($category != 0 && $status != 0) {
        $query .= " AND `category_cat_id`='" . $category . "' ORDER BY `qty` ASC";
    }

    $pid = 0;

    if ($brand != 0 && $model == 0) {
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE
        `brand_id`='" . $brand . "' ORDER BY `qty` ASC");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }
        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `qty` ASC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `qty` ASC";
        }
    }
    if ($brand == 0 && $model != 0) {
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE
        `model_id`='" . $model . "' ORDER BY `qty` ASC");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }

        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `qty` ASC";
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `qty` ASC";
        }
    }

    if ($brand != 0 && $model != 0){
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE 
        `brand_id`='" . $brand . "' AND `model_id`='" . $model . "' ORDER BY `qty` ASC");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }
        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `qty` ASC";
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `qty` ASC";
        }

    }

    if($condition !=0 && $status == 0){
        $query .= "WHERE `condition_condition_id`='".$condition."' ORDER BY `qty` ASC";
        $status = 1;
    }else if($condition != 0 && $status != 0){
        $query .= " AND `condition_condition_id`='".$condition."' ORDER BY `qty` ASC";
    }

    if($color != 0 && $status == 0){
        $query .= "WHERE `color_clr_id`='".$color."' ORDER BY `qty` ASC";
        $status = 1;
    }else if($color != 0 && $status != 0){
        $query .= " AND `color_clr_id`='".$color."' ORDER BY `qty` ASC";
    }

    if(!empty($from) && empty($to)){
        if($status == 0){
            $query .= "WHERE `price`>= '".$from."' ORDER BY `qty` ASC";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price`>='".$from."' ORDER BY `qty` ASC";
        }
    }
    
    if(empty($from) && !empty($to)){
        if($status == 0){
            $query .= "WHERE `price`>= '".$to."' ORDER BY `qty` ASC";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price`>='".$to."' ORDER BY `qty` ASC";
        }
    }

    if(!empty($from) && !empty($to)){
        if($status == 0){
            $query .= "WHERE `price` BETWEEN '".$from."' AND '".$to."' ORDER BY `qty` ASC";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price` BETWEEN '".$from."' AND '".$to."' ORDER BY `qty` ASC";
        }
    }
} else if ($sort == 4) {
    //quantity h 2 l
    if (!empty($search_txt)) {
        $query .= "WHERE `title` LIKE '%" . $search_txt . "%' ORDER BY `qty` DESC";
        $status = 1;
    }

    if ($category != 0 && $status == 0) {
        $query .= "WHERE `category_cat_id`='" . $category . "' ORDER BY `qty` DESC";
    } else if ($category != 0 && $status != 0) {
        $query .= " AND `category_cat_id`='" . $category . "' ORDER BY `qty` DESC";
    }

    $pid = 0;

    if ($brand != 0 && $model == 0) {
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE
        `brand_id`='" . $brand . "' ORDER BY `qty` DESC");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }
        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `qty` DESC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `qty` DESC";
        }
    }
    if ($brand == 0 && $model != 0) {
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE
        `model_id`='" . $model . "' ORDER BY `qty` DESC");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }

        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `qty` DESC";
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `qty` DESC";
        }
    }

    if ($brand != 0 && $model != 0){
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE 
        `brand_id`='" . $brand . "' AND `model_id`='" . $model . "' ORDER BY `qty` DESC");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $$mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }
        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `qty` DESC";
        } else if ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id`='" . $pid . "' ORDER BY `qty` DESC";
        }

    }

    if($condition !=0 && $status == 0){
        $query .= "WHERE `condition_condition_id`='".$condition."' ORDER BY `qty` DESC";
        $status = 1;
    }else if($condition != 0 && $status != 0){
        $query .= " AND `condition_condition_id`='".$condition."' ORDER BY `qty` DESC";
    }

    if($color != 0 && $status == 0){
        $query .= "WHERE `color_clr_id`='".$color."' ORDER BY `qty` DESC";
        $status = 1;
    }else if($color != 0 && $status != 0){
        $query .= " AND `color_clr_id`='".$color."' ORDER BY `qty` DESC";
    }

    if(!empty($from) && empty($to)){
        if($status == 0){
            $query .= "WHERE `price`>= '".$from."' ORDER BY `qty` DESC";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price`>='".$from."' ORDER BY `qty` DESC";
        }
    }
    
    if(empty($from) && !empty($to)){
        if($status == 0){
            $query .= "WHERE `price`>= '".$to."' ORDER BY `qty` DESC";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price`>='".$to."' ORDER BY `qty` DESC";
        }
    }

    if(!empty($from) && !empty($to)){
        if($status == 0){
            $query .= "WHERE `price` BETWEEN '".$from."' AND '".$to."' ORDER BY `qty` DESC";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `price` BETWEEN '".$from."' AND '".$to."' ORDER BY `qty` DESC";
        }
    }
}

$pageno;

if ("0" != $_POST["page"]) {
    $pageno = $_POST["page"];
} else {
    $pageno = 1;
}

$product_rs = Database::search($query);
$product_num = $product_rs->num_rows;

$products_per_page = 3;
$number_of_pages = ceil($product_num / $products_per_page);

$page_results = ($pageno - 1) * $products_per_page;
$selected_rs = Database::search($query . " LIMIT " . $products_per_page .
    " OFFSET " . $page_results . "");
$selected_num = $selected_rs->num_rows;

for ($x = 0; $x < $selected_num; $x++) {
    $selected_data =  $selected_rs->fetch_assoc();
?>
    <div class="offset-lg-1 col-12 col-lg-3">
        <div class="row">

            <div class="card col-6 col-lg-2 mt-2 mb-2" style="width: 18rem;">

                <?php

                $img_rs = Database::search("SELECT * FROM `product_img` WHERE
                `product_id`='" . $selected_data["id"] . "'");
                $img_num = $img_rs->num_rows;
                $img_data = $img_rs->fetch_assoc();

                if ($img_num > 0) {
                ?>
                    <img src="<?php echo $img_data["img_path"]; ?>" class="card-img-top img-thumbnail mt-2" style="height: 180px;" />
                <?php
                } else {
                ?>
                    <img src="resources/mobile_images/iphone12.jpg" class="card-img-top img-thumbnail mt-2" style="height: 180px;" />
                <?php
                }

                ?>


                <div class="card-body ms-0 m-0 text-center">
                    <h5 class="card-title fw-bold fs-6"><?php $selected_data["title"]; ?></h5>
                    <span class="badge rounded-pill text-bg-info">New</span><br />
                    <span class="card-text text-primary">Rs. <?php $selected_data["price"]; ?>.00</span><br />

                    <?php
                    if ($selected_data["qty"] > 0) {
                    ?>
                        <span class="card-text text-warning fw-bold">In Stock</span><br />
                        <span class="card-text text-success fw-bold">10 Items Available</span><br /><br />
                        <a href='#' class="col-12 btn btn-success">Buy Now</a>
                    <?php
                    } else {
                    ?>
                        <span class="card-text text-warning fw-bold">In Stock</span><br />
                        <span class="card-text text-success fw-bold">10 Items Available</span><br /><br />
                        <a href='#' class="col-12 btn btn-success disabled">Buy Now</a>
                    <?php
                    }
                    ?>



                    <button class="col-12 btn btn-dark mt-2">
                        <i class="bi bi-cart-plus-fill text-white fs-5"></i>
                    </button>

                    <button class="col-12 btn btn-outline-light mt-2 border border-primary">
                        <i class="bi bi-heart-fill text-danger fs-5"></i>
                    </button>

                </div>
            </div>

        </div>
    </div>
<?php
}
?>
<div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-lg justify-content-center">
            <li class="page-item">
                <a class="page-link" <?php
                                        if ($pageno <= 1) {
                                            echo ("#");
                                        } else {
                                        ?>
                    onclick="advancedSearch(<?php echo ($pageno - 1); ?>);" ;
                    <?php
                                        }
                    ?>
                    aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php

            for ($x = 1; $x <= $number_of_pages; $x++) {
                if ($x == $pageno) {
            ?>
                    <li class="page-item active">
                        <a class="page-link" onclick="advancedSearch(<?php echo ($x); ?>);">
                            <?php echo $x; ?>
                        </a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="page-item">
                        <a class="page-link" onclick="advancedSearch(<?php echo ($x); ?>);">
                            <?php echo $x; ?>
                        </a>
                    </li>
            <?php
                }
            }

            ?>

            <li class="page-item">
                <a class="page-link" <?php
                                        if ($pageno >= $number_of_pages) {
                                            echo ("#");
                                        } else {
                                        ?>
                    onclick="advancedSearch(<?php echo ($pageno + 1); ?>);" ;
                    <?php
                                        }
                    ?>
                    aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>