<?php

session_start();

include "connection.php";

$receiver_email = $_SESSION["u"]["email"];
$sender = $_GET["e"];

$msg_rs = Database::search("SELECT * FROM `chat` WHERE `from`='" . $receiver_email . "' AND 
`to`='" . $sender . "' OR `from`='" . $sender . "' AND `to`='" . $receiver_email . "'");

$msg_num = $msg_rs->num_rows;


for ($x = 0; $x < $msg_num; $x++) {
    $msg_data = $msg_rs->fetch_assoc();

    if ($msg_data["from"] == $receiver_email) {
?>

        <!-- sent -->
        <div class="offset-3 col-9 media w-75 text-end justify-content-end align-items-end">
            <div class="media-body">
                <div class="bg-primary rounded py-3 px-2 mb-3">
                    <p class="mb-0 fw-bold text-white-50">
                        <?php echo $msg_data["content"]; ?>
                    </p>
                </div>
                <p class="small fw-bold text-black-50 text-end">
                    <?php echo $msg_data["chat_date_time"]; ?>
                </p>
            </div>
        </div>
        <!-- sent -->

    <?php
    } else if ($msg_data["to"] == $receiver_email) {
        $user_rs = Database::search("SELECT * FROM `profile_img` WHERE 
        `user_email`='" . $sender . "'");
        $user_data = $user_rs->fetch_assoc();

    ?>

        <!-- recieved -->
        <div class="media w-75">
            <?php

            if (isset($user_data["img_path"])) {
            ?>
                <img src="<?php echo $user_data["img_path"]; ?>" width="50px" class="rounded-circle" />
            <?php
            } else {
            ?>
                <img src="resources/new_user.svg" width="50px" class="rounded-circle" />
            <?php
            
            }
            ?>

            <div class="media-body">
                <div class="bg-light rounded py-3 px-2 mb-3">
                    <p class="mb-0 fw-bold text-black-50">
                        <?php echo $msg_data["content"]; ?>
                    </p>
                </div>
                <p class="small fw-bold text-black-50 text-end">
                    <?php echo $msg_data["chat_date_time"]; ?>
                </p>
            </div>
        </div>
        <!-- recieved -->


<?php
    }
}

?>