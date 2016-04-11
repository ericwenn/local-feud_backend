<?php
$app->get('/posts/{id}/', function( $req, $res, $args) {

    $date = new DateTime('now');

    $dummyResponse = array(
        'id' => $args['id'],
        'location' => array(
            'latitude' => 32.1231,
            'longitude' => 13.123123,
            'distance' => 7
        ),
        'user' => array(
            'id' => 2,
            'firstname' => 'Krune',
            'lastname' => 'Nilsson',
            'href' => API_ROOT_URL . '/users/2/'
        ),
        'reach' => 5,
        'content' => array(
            'type' => 'text',
            'text' => 'Lorem ipsum dolorem.'
        ),
        'date_posted' => $date->format('c'),
        'is_deleted' => false,
        'comments' => array(
            array(
                'id' => 1,
                'user' => array(
                    'id' => 2,
                    'firstname' => 'Krune',
                    'lastname' => 'Nilsson',
                    'href' => API_ROOT_URL . '/users/2/'
                ),
                'content' => "Lorem ipsum-comment yao.",
                "date_posted" => $date->format('c'),
                "is_original_poster" => true,
                "href" => API_ROOT_URL .'/comments/1/'
            ),
            array(
                'id' => 2,
                'user' => array(
                    'id' => 3,
                    'firstname' => 'Core',
                    'lastname' => 'Tur',
                    'href' => API_ROOT_URL . '/users/3/'
                ),
                'content' => 'Lorem ipsum-comment 2.',
                'date_posted' => $date->format('c'),
                'is_original_poster' => false,
                'href' => API_ROOT_URL . '/comments/2/'
            )
        )
    );


    $newRes = $res->withJson(
        $dummyResponse
    );

    return $newRes;
});