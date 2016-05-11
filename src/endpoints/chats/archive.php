<?php
use LocalFeud\Exceptions\BadRequestException;
use LocalFeud\Exceptions\NotFoundException;
use LocalFeud\Helpers\Age;
use LocalFeud\Helpers\User;
use Pixie\QueryBuilder\JoinBuilder;
use Pixie\QueryBuilder\QueryBuilderHandler;
use Slim\Http\Request;
use Slim\Http\Response;


/**
 * @api {post} /chats/ List chats
 * @apiName ListChats
 * @apiGroup Chat
 *
 *
 *
 * @apiUse Unauthorized
 */

$app->get('/chats/', function($req, $res, $args) {

    /** @var QueryBuilderHandler $qb */
    $qb = $this->querybuilder;


    $chats = $qb->table('chats');

    $chats->join('chat_members', 'chat_members.chatid', '=', 'chats.chatid');

    $chats->where('chat_members.userid', '=', User::getInstance()->getUserId());

    $chats->select([
        'chats.chatid',
        'chats.status',
        'chats.requestsent'
    ]);



    $chats = $chats->get();


    foreach($chats as $chat) {

        $usersInChat = $qb->table('chat_members');
        $usersInChat->leftJoin('users', 'users.id', '=', 'chat_members.userid');

        $usersInChat->where(
            'chat_members.chatid', '=', $chat->chatid
        );

        $usersInChat->whereNot('chat_members.userid', '=', User::getInstance()->getUserId());

        $usersInChat->select([
            'users.firstname',
            'users.lastname',
            'users.birthday',
            'users.sex'
        ]);

        $users = [];
        foreach( $usersInChat->get() as $user ) {
            $users[] = [
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'gender' => $user->sex,
                'age' => Age::toAge($user->birthday)
            ];
        }
        $chat->users = $users;


        // TODO Use real value
        $chat->number_of_unread_messages = 0;

        $d = new DateTime( $chat->requestsent);
        $chat->date_started = $d->format('c');
        unset( $chat->requestsent);


        $chat->id = $chat->chatid;
        unset( $chat->chatid);
    }





    $newRes = $res->withJson(
        $chats
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
 * @apiUse BadRequest
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

    $chats->join( $qb->raw('chat_members as m1'), function( JoinBuilder $table ) use ($qb, $requestedUser) {
        $table->on('m1.chatid', '=', 'chats.chatid');
        $table->on('m1.userid', '=', $qb->raw($requestedUser));
    });

    $chats->join( $qb->raw('chat_members as m2'), function( JoinBuilder $table ) use ($qb, $requestedUser, $requestingUser) {
        $table->on('m2.chatid', '=', 'chats.chatid');
        $table->on('m2.userid', '=', $qb->raw($requestingUser));
    });

    $chats->select([
        'chats.chatid',
        $qb->raw('m1.userid as firstuser'),
        $qb->raw('m2.userid as seconduser')
    ]);

    $chats = $chats->get();


    // If it does exist, throw badrequest
    //if( $chats[0]->firstuser != null && $chats[0]->seconduser != null) {
    if( sizeof($chats) > 0 ) {
        throw new BadRequestException("Chat between users already exists");
    }






    // Check if both persons have commented/posted post
    $posts = $qb->table('post_commentators')->
        where('postid', '=', $postRequestedFrom)->
        where('userid', '=', $requestedUser);

    if( $posts->count() == 0) {
        throw new BadRequestException("User (" . $requestedUser . ") has not commented post (". $postRequestedFrom . ")");
    }




    // Create chat
    $chatID = $qb->table('chats')->insert([

    ]);


    // Insert chatmembers
    $qb->table('chat_members')->insert([
        [
            'chatid' => $chatID,
            'userid' => $requestingUser
        ],
        [
            'chatid' => $chatID,
            'userid' => $requestedUser
        ]
    ]);


    $response = $response->withJson([
        'status' => 200
    ]);

    return $response;
});