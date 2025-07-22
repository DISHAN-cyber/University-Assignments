<?php

include "connection.php";

$brand = $_GET["id"];

$model_rs = Database::search("SELECT * FROM `model` WHERE 
`brand_brand_id` = '".$brand."'");

$model_num = $model_rs->num_rows;

for($x = 0;$x < $model_num;$x++){
    $model_data = $model_rs->fetch_assoc();
    ?>

    <option value="<?php echo $model_data["model_id"];?>">
        <?php echo $model_data["model_name"] ?>
    </option>
    <?php
}

?>