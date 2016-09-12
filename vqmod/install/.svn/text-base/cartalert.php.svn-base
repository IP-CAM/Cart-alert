<?php
        // Add database
        require('../../config.php');
        $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD,DB_DATABASE);
        mysqli_select_db(DB_DATABASE, $con);
        $SQL = "ALTER TABLE `oc_cart` ADD `date_mail` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `date_added`;";
        mysqli_query( $con,$SQL);
        die('Setup Successful !');
?>
