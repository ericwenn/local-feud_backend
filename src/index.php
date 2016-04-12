<?php
    namespace LocalFeud;
    use Pixie\QueryBuilder;
    use Slim\App;
    use Slim\Container;

    require_once "../vendor/autoload.php";
    include("config.php");

    $container = new Container;
    $app = new App($container);

    $connection = new \Pixie\Connection('mysql', $PIXIE_CONFIG, 'QB');




    include("endpoints/posts/archive.php");
    include("endpoints/posts/single.php");
    include("endpoints/posts/single-comments.php");
    include("endpoints/posts/single-likes.php");

    include("endpoints/chats/archive.php");
    include("endpoints/chats/single.php");

    include("endpoints/users/archive.php");
    include("endpoints/users/single.php");


    $app->run();