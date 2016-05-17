<?php
    namespace LocalFeud;
    use Facebook\Exceptions\FacebookResponseException;
    use Facebook\Facebook;
    use Facebook\FacebookResponse;
    use Facebook\GraphNodes\GraphUser;
    use LocalFeud\Exceptions\UnauthorizedException;
    use LocalFeud\Helpers\User;
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

    $container['fb'] = function($c) {
        $fb = new Facebook([
            'app_id' => '1552907468343208',
            'app_secret' => 'd24a95963ec6a368c76a4bb278d64c84',
            'default_graph_version' => 'v2.6'
        ]);
        return $fb;
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
    $app->add(function(Request $request, Response $response, $next) {
        if( !$request->hasHeader('token') || !$request->hasHeader('user-id')) {
            throw new UnauthorizedException('Not authorized');
        }

        $request_userid = $request->getHeader('user-id')[0];
        $request_token = $request->getHeader('token')[0];


        /** @var QueryBuilder\QueryBuilderHandler $qb */
        $qb = $this->querybuilder;

        // Check if the token is valid
        /** @var Facebook $fb */
        $fb = $this->fb;

        User::setInstance($request_userid, $request_token, $qb, $fb);
        

        $response = $next($request, $response);

        return $response;
    });
    
    
    


    include("endpoints/posts/archive.php");
    include("endpoints/posts/single.php");
    include("endpoints/posts/single-comments.php");
    include("endpoints/posts/single-likes.php");

    include("endpoints/chats/archive.php");
    include("endpoints/chats/single.php");
    include("endpoints/chats/single-messages.php");

    include("endpoints/users/archive.php");
    include("endpoints/users/single.php");

    include("endpoints/me/me.php");

    include("endpoints/comments/single.php");

    include("endpoints/gcm.php");

    $app->run();