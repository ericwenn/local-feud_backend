<?php
/**
 * @api {get} /posts/ List of Posts
 * @apiName GetPosts
 * @apiGroup Posts
 *
 * @apiSuccess {Object[]}	posts 					    The Posts
 * @apiSuccess {Number} 	posts.id 				    ID of the Post
 * @apiSuccess {Number}	    posts.reach				    Reach of the Post, measured in kilometers
 * @apiSuccess {Date}		posts.date_posted		    Date when the Post was created
 * @apiSuccess {Number}	    posts.number_of_comments    Number of Comments on the Post
 * @apiSuccess {Number}	    posts.number_of_likes       Number of Likes on the Post
 *
 * @apiSuccess {Object[]}	posts.user 			        The User who created the Post
 * @apiSuccess {Number}		posts.user.id 		        ID of the User
 * @apiSuccess {URL}		posts.user.href 		    Reference to the endpoint
 *
 * @apiSuccess {Object[]}	posts.content				The content of the Post
 * @apiSuccess {String}		posts.content.type          The type of content the Post has
 * @apiSuccess {String}		posts.content.text 	        The text of the Post. Only returned if content.type == 'text'
 * @apiSuccess {String}		posts.content.image_src 	URL of Posts image. Only returned if content.type == 'image'
 *
 * @apiSuccess {Object[]}	posts.location		        Information of the location of the Post.
 * @apiSuccess {Number}		posts.location.distance     Number between 0 and 10 denoting the distance from the post
 *
 * @apiSuccess {String}		posts.href				    Reference to the endpoint
 */

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