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
    include("endpoints/posts/single-comments.php");
    include("endpoints/posts/single-likes.php");

    include("endpoints/chats/archive.php");
    include("endpoints/chats/single.php");
    $app->run();