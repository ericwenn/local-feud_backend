<?php
$app->get('/chats/', function( $req, $res, $args) {

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
