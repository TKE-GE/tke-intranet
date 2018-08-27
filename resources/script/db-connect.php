<?php
    //- Fill in fields as necessary.
    $username = 'tke-ge-user';
    $password = '1949tke2018';
    $host     = 'localhost';
    $dbname   = 'tke-ge';
    
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    
    $errorMessage  = "Error connecting to database. Please contact
            <a href=\"mailto:jonesc11@rpi.edu\">jonesc11@rpi.edu</a>\n";
    
    //- Check creating the databases
    try {
        $db = new PDO("mysql:host=" . $host . ";dbname=" . $dbname
                . ";charset=utf8", $username, $password);
    } catch (PDOException $e) {
        echo($e);
        die ($errorMessage);
    }
    
    //- Set defaults to make things easier to read.
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    header('Content-Type: text/html; charset=utf-8');
    
    //- Loads session variables.
    session_start();
    
    //- Run create tables to create the tables if they don't already exist
    require('create-tables.php');
