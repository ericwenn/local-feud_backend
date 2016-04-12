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