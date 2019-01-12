<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');

    /** 
     * Returns a random salt.
     */
    function salt() {
        return dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
    }

    /**
     * Hashes the given password with the salt.
     * @param password is the human-readable password to salt.
     * @param salt is the salt to hash with the password.
     * @return a hashed password.
     */
    function hashPassword($pass, $salt) {
        $hashedPassword = hash('sha256', $pass . $salt);

        for ($i = 0; $i < 23141; ++$i) {
            $hashedPassword = hash('sha256', $hashedPassword . $salt);
        }

        return $hashedPassword;
    }

    /**
     * Creates a new user with the given email, firstname, and lastname. A
     * password is created upon creation.
     * @param email is the '@rpi.edu' to use.
     * @param password is the human-readable password to create the user with.
     * @param firstname is the first name of the new user.
     * @param lastname is the last name of the new user.
     * @return true if the user was successfully created, false otherwise.
     */
    function createNewUser($email, $password, $firstname, $lastname) {
        global $db;

        $salt = salt();
        $pass = hashPassword($password, $salt);

        $query = "INSERT INTO `users` "
            . "(`school_email`, `password`, `salt`, `firstname`, `lastname`) VALUES "
            . "(:email, :password, :salt, :firstname, :lastname);";
        $parameters = [ ':email'     => $email,
                        ':password'  => $pass,
                        ':salt'      => $salt,
                        ':firstname' => $firstname,
                        ':lastname'  => $lastname ];

        try {
            $statement = $db->prepare($query);
            $result = $statement->execute($parameters);
            return $result;
        } catch (PDOException $e) {
            die($e);
            return FALSE;
        }
    }

    /**
     * Tells whether the user is logged in or not.
     * @return true if the user is logged in, false otherwise.
     */
    function isLoggedIn() {
        return isset($_SESSION['user']) && isset($_SESSION['user']['school_email']) &&
            isset($_SESSION['user']['password']) &&
            isValid($_SESSION['user']['school_email'], $_SESSION['user']['password']);
    }

    /** 
     * Gets the role of the user with the given email.
     * @param email is the '@rpi.edu' email to get the role of.
     * @return the role of the given user, false if the user does not exist or
     *     does not have a role.
     */
    function getRole($email) {
        global $db;

        $statement = $db->prepare("SELECT `role` FROM `users` WHERE `email` = :email");
        $result = $statement->execute([ ':email' => $email ]);

        return $result->fetch();
    }

    /**
     * Given an email and hashed password, return if this is a valid combination.
     * @param email is the RPI email of the user we are checking.
     * @param password is the hashed password of the user we are checking.
     * @return the user's row if the email and password match, false otherwise.
     */
    function isValid($email, $password) {
        if (($row = getUserRow($email)) !== false) {
            unset($row['salt']);
            return $row['password'] === $password ? $row : false;
        }

        return false;
    }

    /**
     * Given an email and human-readable password, return if the login is valid or not.
     * @param email is the user's email to log in.
     * @param password is the human-readable password for the user.
     * @return the user's row if the login was successful, false otherwise.
     */
    function verifyLogin($email, $password) {
        if (!isset($email) || !isset($password)) {
            return false;
        }

        if (($row = getUserRow($email)) !== false) {
            $hashedPassword = hashPassword($password, $row['salt']);
            unset($row['salt']);
            return $row['password'] === $hashedPassword ? $row : false;
        }

        return false;
    }

    /**
     * Gets a row for a user with a given email.
     * @param rpiemail is the user's rpi email.
     * @return the user's row if in the database, false otherwise.
     */
    function getUserRow($rpiemail) {
        global $db;

        if (!isset($rpiemail)) {
            return false;
        }

        $statement = $db->prepare("SELECT * FROM `users` WHERE `school_email` = :email;");
        $result = $statement->execute([ ':email' => trim($rpiemail) ]);

        if ($result !== false) {
            return $statement->fetch();
        }

        return false;
    }
?>
