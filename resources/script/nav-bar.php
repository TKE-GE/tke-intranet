<?php 
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'auth-helpers.php');

    $menuItems = [
        'Home' => '/'
    ];

    if (isLoggedIn()) {
        $menuItems['Logout'] = '/logout';
    } else {
        $menuItems['Login'] = '/login';
    }
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">TKE-GE</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php
                foreach ($menuItems as $key => $value) {
                    if ($key == $activeTab) {
                        echo('<li class="nav-item active"><a class="nav-link" href="'
                            . $value . '">' . $key . ' <span class="sr-only">'
                            . '(current)</span></a></li>');
                    } else {
                        echo('<li class="nav-item"><a class="nav-link" href="'
                            . $value . '">' . $key . '</a></li>');
                    }
                }
            ?>
        </ul>
    </div>
</nav>
