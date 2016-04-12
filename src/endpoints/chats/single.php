<?php
$app->get('/chats/{id}/', function( $req, $res, $args) {

    $date = new DateTime('now');

    $dummyResponse = array(
        array(
            'id' => 1,
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
            'messages' => array(
                array(
                    'id' => '1',
                    'user' => array(
                        'id' => 1
                    ),
                    'content' => 'Lorem ipsum dolorem.',
                    'date_sent' => $date->format('c'),
                    'read_by' => array(
                        array(
                            'id' => 1
                        )
                    )

                )
            )
        )
    );


    $newRes = $res->withJson(
        $dummyResponse
    );

    return $newRes;
});
