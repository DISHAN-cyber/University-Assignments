<?php

include "connection.php";

$district = $_GET["id"];

$city_rs = Database::search("SELECT * FROM `city` WHERE 
`district_district_id` = '".$district."'");

$city_num = $city_rs->num_rows;

for($x = 0;$x < $city_num;$x++){
    $city_data = $city_rs->fetch_assoc();
    ?>

    <option value="<?php echo $city_data["city_id"];?>">
        <?php echo $city_data["city_name"] ?>
    </option>
    <?php
}

?>