<?php

include "connection.php";

$title = $_POST["t"];
$qty = $_POST["q"];
$dwc = $_POST["dwc"];
$doc = $_POST["doc"];
$desc = $_POST["d"];
$id = $_POST["pid"];

Database::iud("UPDATE `product` SET `title`='" . $title . "', `qty`='" . $qty . "',
`delivery_fee_colombo`='" . $dwc . "',`delivery_fee_other`='" . $doc . "',
`description`='" . $desc . "' WHERE `id`='" . $id . "'");

echo ("Product has been Updated.");

$length = sizeof($_FILES);

if($length <= 3 && $length > 0){

    $allowed_img_extensions = array("image/jpeg","image/png","image/svg+xml");

    $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='".$id."'");
    $img_num = $img_rs->num_rows;
    
    for($a = 0;$a < $img_num;$a++){
        $img_data = $img_rs->fetch_assoc();

        unlink(($img_data["img_path"]));
        Database::iud("DELETE FROM `product_img` WHERE `product_id`='".$id."' ");
    }

    for($x = 0;$x < $length;$x++){
        if(isset($_FILES["image".$x])){
            $image_file = $_FILES["image".$x];
            $file_extension = $image_file["type"];
            
            if(in_array($file_extension,$allowed_img_extensions)){
                
                $new_image_extension;

                if($file_extension == "image/jpeg"){
                    $new_image_extension = ".jpeg";
                }else if($file_extension == "image/png"){
                    $new_image_extension = ".png";
                }else if($file_extension == "image/svg+xml"){
                    $new_image_extension = ".svg";
                }

                $file_name = "resources//product_images//".$title.$x.uniqid().$new_image_extension;
                move_uploaded_file($image_file["tmp_name"],$file_name);

                Database::iud("INSERT INTO `product_img`(`img_path`,`product_id`) VALUES 
                ('".$file_name."','".$product_id."')");

            }else{
                echo ("Invalid image type.");
            }
        }
    }

    echo("success");

}else{
    echo("Invalid Image Count.");
}


?>
