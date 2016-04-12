<?php
/**
 * @api {get} /posts/[id]/likes/ Likes on a Post
 * @apiGroup Posts
 *
 * @apiSuccess {Object[]}	likes 					    The Likes
 * @apiSuccess {Number} 	likes.id 				    ID of the Like
 * @apiSuccess {Date}		posts.date_liked    	    Date when the Post was liked
 * @apiSuccess {Number}	    posts.is_original_poster    If the User is also the Author of the Post
 *
 * @apiSuccess {Object[]}	posts.user 			        The User who created the Post
 * @apiSuccess {Object[]}	posts.user.firstname		Firstname of the User
 * @apiSuccess {Object[]}	posts.user.lastname 	    Lastname of the User
 * @apiSuccess {Number}		posts.user.id 		        ID of the User
 * @apiSuccess {URL}		posts.user.href 		    Reference to the endpoint
 */
	$app->get('/posts/{id}/likes/', function( $req, $res, $args) {

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
                'date_liked' => $date->format('c'),
                'is_original_poster' => false,
                'href' => API_ROOT_URL . '/likes/1/'
            ),
            array(
                'id' => 2,
                'user' => array(
                    'id' => 1,
                    'firstname' => 'Karl',
                    'lastname' => 'Karlsson',
                    'href' => API_ROOT_URL . '/users/1/'
                ),
                'date_liked' => $date->format('c'),
                'is_original_poster' => false,
                'href' => API_ROOT_URL . '/likes/2/'
            )
        );


        $newRes = $res->withJson(
           $dummyResponse
        );

        return $newRes;
    });