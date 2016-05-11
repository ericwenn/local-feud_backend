<?php
use LocalFeud\Exceptions\NotFoundException;
use Pixie\QueryBuilder\QueryBuilderHandler;
use Slim\Http\Request;
use Slim\Http\Response;

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