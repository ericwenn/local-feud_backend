<?php
	$app->get('/posts/', function( $req, $res, $args) {

        $date = new DateTime('now');

        $dummyResponse = array(
            array(
                'id' => 1,
                'location' => array(
                    'distance' => 5
                ),
                'user' => array(
                    'id' => 1,
                    'firstname' => 'Karl',
                    'lastname' => 'Karlsson',
                    'href' => API_ROOT_URL . '/users/1/'
                ),
                'reach' => 5,
                'content' => array(
                    'type' => 'text',
                    'text' => 'Lorem ipsum dolorem.'
                ),
                'number_of_comments' => 10,
                'number_of_likes' => 20,
                'date_posted' => $date->format('c'),
                'href' => API_ROOT_URL . '/posts/1/'
            ),
            array(
                'id' => 2,
                'location' => array(
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
                'number_of_comments' => 10,
                'number_of_likes' => 20,
                'date_posted' => $date->format('c'),
                'href' => API_ROOT_URL . '/posts/2/'
            )
        );


        $newRes = $res->withJson(
           $dummyResponse
        );

        return $newRes;
    });