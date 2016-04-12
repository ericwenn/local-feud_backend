<?php
	$app->get('/posts/{id}/comments/', function( $req, $res, $args) {

        $date = new DateTime('now');

        $dummyResponse = array(
            array(
                'id' => 1,
                'user' => array(
                    'id' => 1,
                    'firstname' => 'Karl',
                    'lastname' => 'Karlsson',
                    'href' => API_ROOT_URL . '/users/1/'
                ),
                'content' => 'Lorem ipsum dolorem-comment.',
                'date_posted' => $date->format('c'),
                'is_original_poster' => false,
                'href' => API_ROOT_URL . '/posts/1/'
            ),
            array(
                'id' => 2,
                'user' => array(
                    'id' => 1,
                    'firstname' => 'Karl',
                    'lastname' => 'Karlsson',
                    'href' => API_ROOT_URL . '/users/1/'
                ),
                'content' => 'Lorem ipsum dolorem-comment.',
                'date_posted' => $date->format('c'),
                'is_original_poster' => false,
                'href' => API_ROOT_URL . '/posts/1/'
            )
        );


        $newRes = $res->withJson(
           $dummyResponse
        );

        return $newRes;
    });