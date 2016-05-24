<?php
use LocalFeud\Helpers\Age;
use LocalFeud\Helpers\User;
use Pixie\QueryBuilder\QueryBuilderHandler;

$app->get('/chats/{id}/', function($req, $res, $args) {

    /** @var QueryBuilderHandler $qb */
    $qb = $this->querybuilder;

    $chatID = $args['id'];



    $chats = $qb->table('chats')->where('chats.chatid', $chatID);

    $chats->join('chat_members', 'chat_members.chatid', '=', 'chats.chatid');

    $chats->where('chat_members.userid', '=', User::getInstance()->getUserId());

    $chats->select([
        'chats.chatid',
        'chats.status',
        'chats.requestsent'
    ]);



    $chats = $chats->get();

    if( sizeof($chats) > 0 ) {


        foreach ($chats as $chat) {

            $usersInChat = $qb->table('chat_members');
            $usersInChat->leftJoin('users', 'users.id', '=', 'chat_members.userid');

            $usersInChat->where(
                'chat_members.chatid', '=', $chat->chatid
            );

            $usersInChat->whereNot('chat_members.userid', '=', User::getInstance()->getUserId());

            $usersInChat->select([
                'users.id',
                'users.firstname',
                'users.lastname',
                'users.birthday',
                'users.sex'
            ]);

            $users = [];
            foreach ($usersInChat->get() as $user) {
                $users[] = [
                    'id' => $user->id,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'gender' => $user->sex,
                    'age' => Age::toAge($user->birthday)
                ];
            }
            $chat->users = $users;


            // TODO Use real value
            $chat->number_of_unread_messages = 0;

            $d = new DateTime($chat->requestsent);
            $chat->date_started = $d->format('c');
            unset($chat->requestsent);


            $chat->id = $chat->chatid;
            unset($chat->chatid);


            // Format last message
            $last_message = $qb->table('chat_messages')->where('chatid', '=', $chat->id)->orderBy('id', 'DESC')->limit(1);
            $last_message->select('timesent', 'message');
            $last_message = $last_message->get();

            if (sizeof($last_message) > 0) {
                $chat->last_message = $last_message[0]->message;
                $d = new DateTime($last_message[0]->timesent);
                $chat->last_activity = $d->format('c');
            } else {
                $chat->last_message = null;
                $chat->last_activity = null;
            }
        }
    } else {
        throw new \LocalFeud\Exceptions\NotFoundException("Chat doesnt exist");
    }





    $newRes = $res->withJson(
        $chats
    );

    return $newRes;
});
