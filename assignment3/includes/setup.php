<?php
    // Existing DDL
    $dbsql = "CREATE DATABASE IF NOT EXISTS webdev_project;";

    $servicessql = "CREATE TABLE IF NOT EXISTS services (
        id int NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        description varchar(5000),
        image varchar(400),
        PRIMARY KEY (id) 
    );";

    $userssql = "CREATE TABLE IF NOT EXISTS users (
        id int NOT NULL AUTO_INCREMENT,
        username varchar(255) NOT NULL UNIQUE,
        email varchar(255) NOT NULL UNIQUE,
        password varchar(255) NOT NULL,
        PRIMARY KEY (id)
    );";

    $messagessql = "CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";

    // New DDL for page_views table
    $pageviewssql = "CREATE TABLE IF NOT EXISTS page_views (
        id INT AUTO_INCREMENT PRIMARY KEY,
        page_name VARCHAR(255) NOT NULL UNIQUE,
        view_count INT NOT NULL DEFAULT 0,
        last_viewed TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );";
    // END New DDL

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "webdev_project"; // Database name
    
    // Create connection
    $conn = new mysqli($servername, $username, $password);
    
    // Check connection
    if ($conn->connect_error) { 
      die("Connection failed: " . $conn->connect_error);
    }

    
    if (!$conn->query($dbsql)) {
        // Optionally handle error, but usually IF NOT EXISTS is fine
    }
    
    // Select the database
    if (!$conn->select_db($db)) {
        die("Database selection failed: " . $conn->error);
    }

    
    if (!$conn->query($userssql)) {
       
    }
    if (!$conn->query($servicessql)) {
        
    }
    if (!$conn->query($messagessql)) {
        
    }
    if (!$conn->query($pageviewssql)) { 
        
    }


?>