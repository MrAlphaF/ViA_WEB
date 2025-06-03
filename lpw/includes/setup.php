<?php
    $dbsql = "CREATE DATABASE IF NOT EXISTS webdev_project;";

    $servicessql = "CREATE TABLE IF NOT EXISTS services 
    (
    id int NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    description varchar(5000),
    image varchar(400),
    PRIMARY KEY (id) 
    );";

    $userssql = "CREATE TABLE IF NOT EXISTS users 
    (
    id int NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL UNIQUE,
    email varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    PRIMARY KEY (id)
    );";

    // Added for Task 6.3
    $messagessql = "CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";

    //Added for LPW
    $statssql = "CREATE TABLE IF NOT EXISTS stats (
      id INT AUTO_INCREMENT PRIMARY KEY,
      page_name VARCHAR(100) NOT NULL,
      view_count INT NOT NULL,
      last_viewed TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
    $conn->query($messagessql); // Added for Task 6.3
    $conn->query($statssql); // Added for LPW

?>