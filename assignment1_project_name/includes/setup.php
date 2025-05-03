<?php
    $dbsql = "CREATE DATABASE IF NOT EXISTS webdev_project;";

    $servicessql = "CREATE TABLE IF NOT EXISTS services 
    (
    id int NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    description varchar(5000),
    PRIMARY KEY (id) 
    );";

    $userssql = "CREATE TABLE IF NOT EXISTS users 
    (
    id int NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    PRIMARY KEY (id)
    );";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "webdev_project";
    
    $conn = new mysqli($servername, $username, $password);
    
    if (!$conn) {
      die("Connection died: " . mysqli_connect_error());
    }

    $conn->query($dbsql);
    $conn->select_db($db);
    $conn->query($userssql);
    $conn->query($servicessql);

?>