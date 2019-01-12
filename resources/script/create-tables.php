<?php
    function executeQuery($query, $table) {
        global $db;

        try {
            $statement = $db->prepare($query);
            if ($statement->execute() === FALSE) {
                die('Error creating table: ' . $table);
            }
        } catch (PDOException $e) {
            die('Error creating table: ' . $table . $e);
        }
    }

    $query = 'CREATE TABLE IF NOT EXISTS users ('
            . 'id int NOT NULL AUTO_INCREMENT,'
            . 'school_email varchar(64) NOT NULL UNIQUE,'
            . 'password varchar(128) NOT NULL,'
            . 'salt varchar(16) NOT NULL,'
            . 'role varchar(64),'
            . 'phone varchar(14),'
            . 'personal_email varchar(64),'
            . 'rin varchar(9) UNIQUE,'
            . 'rpi_address varchar(256),'
            . 'home_address varchar(256),'
            . 'major varchar(128),'
            . 'year char(4),'
            . 'firstname varchar(32) NOT NULL,'
            . 'lastname varchar(32) NOT NULL,'
            . 'PRIMARY KEY(id)'
            . ');';

    executeQuery($query, 'users');
?>
