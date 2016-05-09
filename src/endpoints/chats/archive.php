<?php
use LocalFeud\Exceptions\BadRequestException;
use LocalFeud\Exceptions\NotFoundException;
use LocalFeud\Helpers\User;
use Pixie\QueryBuilder\JoinBuilder;
use Pixie\QueryBuilder\QueryBuilderHandler;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/chats/', function($req, $res, $args) {

    $date = new DateTime('now');

    $dummyResponse = array(
        array(
            'id' => 1,
            'status' => 'accepted',
            'users' => array(
                array(
                    'id' => 1,
                    'firstname' => 'Karl',
                    'lastname' => 'Karlsson',
                    'href' => API_ROOT_URL . '/users/1/'
                ),
                array(
                    'id' => 2,
                    'firstname' => 'Johan',
                    'lastname' => 'Ulvgren',
                    'href' => API_ROOT_URL . '/users/2/'
                )
            ),
            'date_started' => $date->format('c'),
            'number_of_unread_messages' => 0,
            'href' => API_ROOT_URL . '/chats/1/'
        ),
        array(
            'id' => 2,
            'users' => array(
                array(
                    'id' => 1,
                    'firstname' => 'Karl',
                    'lastname' => 'Karlsson',
                    'href' => API_ROOT_URL . '/users/1/'
                ),
                array(
                    'id' => 2,
                    'firstname' => 'Johan',
                    'lastname' => 'Ulvgren',
                    'href' => API_ROOT_URL . '/users/2/'
                )
            ),
            'status' => 'accepted',
            'date_started' => $date->format('c'),
            'number_of_unread_messages' => 2,
            'href' => API_ROOT_URL . '/chats/2/'
        )
    );


    $newRes = $res->withJson(
        $dummyResponse
    );

    return $newRes;
});







/**
 * @api {post} /chats/ Start chat with user
 * @apiName StartChat
 * @apiGroup Chat
 *
 * @apiParam {Number}   userid      ID of the User to request a chat with
 * @apiParam {NUmber}   postid      ID of the Post where Chat was initiated
 *
 * @apiParamExample {json} Request-Example
 *      {
 *          "userid": 1
 *          "postid": 1
 *      }
 *
 *
 * @apiUse Unauthorized
 * @apiUse NotFound
 */


$app->post('/chats/', function( Request $request, Response $response, $args) {
    $parameters = $request->getParsedBody();

    if( !isset($parameters['userid']) || !isset($parameters['postid'])) {
        throw new BadRequestException("User ID or Post ID not set.");
    }

    // The user who requested the chat
    $requestingUser = User::getInstance()->getUserId();

    // The user to be requested
    $requestedUser = $parameters['userid'];

    // The post where the request was started
    $postRequestedFrom = $parameters['postid'];




    /** @var QueryBuilderHandler $qb */
    $qb = $this->querybuilder;



    // Check if request is to yourself
    if( $requestedUser == $requestingUser ) {
        throw new BadRequestException("You cant start a chat with yourself");
    }







    // Check if user exists
    $users = $qb->table('users')->where('id', '=', $requestedUser);
    if( $users->count() == 0) {
        throw new NotFoundException("User (" . $requestedUser . ") doesnt exist");
    }








    // Check if post exists
    $posts = $qb->table('posts')->where('id', '=', $postRequestedFrom);
    if($posts->count() == 0) {
        throw new NotFoundException("Post (" . $postRequestedFrom . ") doesnt exist");
    }











    // Check if another chat between these two exists
    $chats = $qb->table('chats');

    $chats->leftJoin( $qb->raw('chat_members as m1'), function( JoinBuilder $table ) use ($qb, $requestedUser) {
        $table->on('m1.chatid', '=', 'chats.chatid');
        $table->on('m1.userid', '=', $qb->raw($requestedUser));
    });

    $chats->leftJoin( $qb->raw('chat_members as m2'), function( JoinBuilder $table ) use ($qb, $requestedUser, $requestingUser) {
        $table->on('m2.chatid', '=', 'chats.chatid');
        $table->on('m2.userid', '=', $qb->raw($requestingUser));
    });

    $chats->select([
        $qb->raw('m1.userid as firstuser'),
        $qb->raw('m2.userid as seconduser')
    ]);

    $chats = $chats->get();

    // If it does exist, throw badrequest
    if( $chats[0]->firstuser != null && $chats[0]->seconduser != null) {
        throw new BadRequestException("Chat between users already exists");
    }






    // Check if both persons have commented/posted post
    $posts = $qb->table('post_commentators')->
        where('postid', '=', $postRequestedFrom)->
        where('userid', '=', $requestedUser);

    print_r($posts->get());




    // If it exists BadRequest

    //

    return $response;
});