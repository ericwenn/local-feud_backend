<?php
    namespace LocalFeud;
    use Slim\App;
    use Slim\Container;

    require_once "../vendor/autoload.php";

    $container = new Container;
    $app = new App($container);


    print_r($app);