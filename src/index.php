<?php
    namespace LocalFeud;
    use LocalFeud\Exceptions\UnauthorizedException;
    use Pixie\QueryBuilder;
    use Slim\App;
    use Slim\Container;
    use Slim\Http\Request;
    use Slim\Http\Response;

    require_once "../vendor/autoload.php";
    include("config.php");



    $container = new Container;
    $container['querybuilder'] = function($c) use($PIXIE_CONFIG) {
        $connection = new \Pixie\Connection('mysql', $PIXIE_CONFIG);
        $qb = new \Pixie\QueryBuilder\QueryBuilderHandler($connection);

        return $qb;
    };





    $container['errorHandler'] = function($c) {
        return function( Request $req, Response $res, \Exception $e) {

            if( $e instanceof Exceptions\Exception ) {
                return $res->
                withStatus( $e->getCode() )->
                withJson(
                    array(
                        'status' => $e->getCode(),
                        'message' => $e->getMessage()
                    )
                );

            } else {
                return $res->
                    withStatus(500)->withJson(array(
                    'message' => $e->getMessage()
                ));
            }
        };
    };

    
    $app = new App($container);





    // Setup authentication middleware
    $app->add(function($request, $response, $next) {
        throw new UnauthorizedException("Not authorized");
        $response = $next($request, $response);

        return $response;
    });


    include("endpoints/posts/archive.php");
    include("endpoints/posts/single.php");
    include("endpoints/posts/single-comments.php");
    include("endpoints/posts/single-likes.php");

    include("endpoints/chats/archive.php");
    include("endpoints/chats/single.php");

    include("endpoints/users/archive.php");
    include("endpoints/users/single.php");


    $app->run();