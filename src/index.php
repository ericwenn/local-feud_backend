<?php
    namespace LocalFeud;
    use Slim\App;
    use Slim\Container;

    require_once "../vendor/autoload.php";

    $container = new Container;
    $app = new App($container);


    include("config.php");

    include("endpoints/posts/archive.php");
    include("endpoints/posts/single.php");

    
    $app->run();