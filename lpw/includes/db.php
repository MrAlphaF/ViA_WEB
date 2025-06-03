<?php
    include __DIR__ . "/../classes/database.php";
    // username, password, dbname, servername
    $mydb = new MyDB("root", "", "webdev_project", "localhost");

    $dbh = new PDO('mysql:host='.$mydb->get_servername().';dbname='.$mydb->get_dbname(), $mydb->get_username(), $mydb->get_password());
?>