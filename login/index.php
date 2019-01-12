<?php
    require_once('../resources/script/auth-helpers.php');

    $loginErrors = [];

    if (isset($_SESSION['user'])
            && isValid($_SESSION['user']['school_email'],
                $_SESSION['user']['password'])) {
        header('Location: /');
    }

    if (isset($_POST) && isset($_POST['email']) && isset($_POST['password'])) {
        if (($user = verifyLogin($_POST['email'], $_POST['password'])) !== false) {
            $_SESSION['user'] = $user;
            header('Location: /');
        } else {
            $loginErrors[] = 'Username and password do not match.';
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Bootstrap CDN -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
            crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"
            integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl"
            crossorigin="anonymous"></script>

        <!-- AngularJS CDN -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.2/angular.min.js"
            crossorigin="anonymous"></script>

        <title>Login | TKE RPI</title>
    </head>
    <body>
        <?php 
            $activeTab = 'Login';
            require_once(__DIR__ . DIRECTORY_SEPARATOR . '..'
                . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR
                . 'script' . DIRECTORY_SEPARATOR . 'nav-bar.php');
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <?php foreach ($loginErrors as $error) {
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    } ?>
                    <h1 class="center">Login to TKE RPI</h1>
                    <form method="post" action="/login/index.php">
                        <label for="email">RPI Email Address</label><br />
                        <input type="email" class="form-control" name="email"
                            placeholder="RPI Email Address" />
                        <label for="password">Password</label><br />
                        <input type="password" class="form-control"
                            name="password" placeholder="Password" />
                        <input type="submit" name="submit" value="Log in"
                            class="form-control" />
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
