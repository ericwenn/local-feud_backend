<?php
use LocalFeud\Exceptions\BadRequestException;
use LocalFeud\Exceptions\NotFoundException;
use LocalFeud\Helpers\User;
use Pixie\QueryBuilder\QueryBuilderHandler;
use Respect\Validation\Validator;
use Slim\Http\Request;
use Slim\Http\Response;


/**
 * @api {get} /chats/[id]/messages/ List chat messages
 * @apiName ListChatMessages
 * @apiGroup Chat
 *
 * @apiSuccess {Object[]}   messages
 * @apiSuccess {Number}     messages.id             ID of the message
 * @apiSuccess {Object[]}   messages.user           The user who sent the message
 * @apiSuccess {Number}     messages.user.id        id of user
 * @apiSuccess {Number}     messages.user.fistname  Firstname of user
 * @apiSuccess {Number}     messages.user.lastname  Lastname of user
 * @apiSuccess {Date}       messages.timesent       Date when the message was posted
 *
 *
 * @apiUse Unauthorized
 */

$app->get('/chats/{id}/messages/', function(Request $req, Response $res, $args) {

    $chatID = $args['id'];

    /** @var QueryBuilderHandler $qb */
    $qb = $this->querybuilder;


    // Check if chat exists
    $chat = $qb->table('chats')->where('chatid', '=', $chatID);

    if( $chat->count() == 0) {
        throw new NotFoundException("Chat doesnt exist");
    }




    $messages = $qb->table('chat_messages')->where('chatid', '=', $chatID);

    $messages->leftJoin('users', 'chat_messages.sender', '=', 'users.id');

    $messages->select([
        'chat_messages.id',
        'chat_messages.sender',
        'chat_messages.message',
        'chat_messages.timesent',
        'users.firstname',
        'users.lastname'
    ]);


    $messages = $messages->get();


    foreach($messages as $message) {

        // Format user
        $user = [
            'id' => $message->sender,
            'firstname' => $message->firstname,
            'lastname' => $message->lastname
        ];

        $message->user = $user;

        unset( $message->sender );
        unset( $message->firstname );
        unset( $message->lastname );


        // Format timesent

        $d = new DateTime( $message->timesent );
        $message->timesent = $d->format('c');


    }




    $newRes = $res->withJson(
        $messages,
        null,
        JSON_NUMERIC_CHECK
    );

    return $newRes;
});




/**
 * @api {post} /chats/[id]/messages/ Send chat messages
 * @apiName SendChatMessages
 * @apiGroup Chat
 *
 * @apiParam {String}   message     Message to send
 *
 * @apiUse BadRequest
 * @apiUse NotFound
 * @apiUse Unauthorized
 */


$app->post('/chats/{id}/messages/', function(Request $req, Response $res, $args) {

    $chatID = $args['id'];

    /** @var QueryBuilderHandler $qb */
    $qb = $this->querybuilder;


    /**
     * Check if chat exists
     */
    $chat = $qb->table('chats')->where('chatid', '=', $chatID);

    if( $chat->count() == 0) {
        throw new NotFoundException("Chat doesnt exist");
    }




    /**
     * Validate message
     */
    $parameters = $req->getParsedBody();

    if( !isset($parameters['message'])) {
        throw new BadRequestException("Message not set.");
    }

    $message = $parameters['message'];


    if( !Validator::length(1, 3000)->validate($message)) {
        throw new BadRequestException("Message too long");
    }


    $messagetable = $qb->table('chat_messages');

    $messagetable->insert([
        'sender' => User::getInstance()->getUserId(),
        'chatid' => $chatID,
        'message' => $message
    ]);


    $response = $res->withJson([
        'status' => 200
    ]);
    return $response;


});





