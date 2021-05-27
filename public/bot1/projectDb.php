<?php

      
function projectDb() {

    // Enter your MySQL database credentials
    $mysql_credentials_project = [
       'host'     => '127.0.0.1',
       'user'     => 'root',
       'password' => 'Qwertyuiop0987654321',
       'database' => 'truck',
    ];

    //Create database connection
    $dblink = new mysqli($mysql_credentials_project['host'], $mysql_credentials_project['user'], $mysql_credentials_project['password'], $mysql_credentials_project['database']);
    $dblink -> set_charset("utf8");

    //Check connection was successful
    if ($dblink->connect_errno) {
     printf("Failed to connect to database");
     exit();
    }

    return $dblink;
}