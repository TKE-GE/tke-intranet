<?php
    require_once('..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR
            . 'script' . DIRECTORY_SEPARATOR . 'db-connect.php');

    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }

    header('Location: /login');
?>
