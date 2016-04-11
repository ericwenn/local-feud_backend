<?php
    namespace LocalFeud;
    use Slim\App;
    use Slim\Container;

    require_once "../vendor/autoload.php";

    $container = new Container;
    $app = new App($container);


    $app->get('/', function( $req, $res, $args) {
    });

    include("endpoints/posts/archive.php");

    $app->run();