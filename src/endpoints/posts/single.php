<?php
/**
 * @api {get} /posts/{id}/ Single Post
 * @apiName GetPost
 * @apiGroup Posts
 *
 * @apiIgnore
 *
 * @apiSuccess {Number} 	id 				        ID of the Post
 * @apiSuccess {Number}	    reach				    Reach of the Post, measured in kilometers
 * @apiSuccess {Date}		date_posted		        Date when the Post was created
 * @apiSuccess {Number}	    number_of_comments      Number of Comments on the Post
 * @apiSuccess {Number}	    number_of_likes         Number of Likes on the Post
 *
 * @apiSuccess {Object[]}	user 			        The User who created the Post
 * @apiSuccess {Number}		user.id 		        ID of the User
 * @apiSuccess {URL}		user.href 		        Reference to the Users endpoint
 *
 * @apiSuccess {Object[]}	content				    The content of the Post
 * @apiSuccess {String}		content.type            The type of content the Post has
 * @apiSuccess {String}		content.text 	        The text of the Post. Only returned if content.type == 'text'
 * @apiSuccess {String}		content.image_src 	    URL of Posts image. Only returned if content.type == 'image'
 *
 * @apiSuccess {Object[]}	location		        Information of the location of the Post.
 * @apiSuccess {Number}		location.distance       Number between 0 and 10 denoting the distance from the post
 * @apiSuccess {Number}     location.latitude
 * @apiSuccess {Number}     location.longitude
 *
 */

$app->get('/posts/{id}/', function( \Slim\Http\Request $req, \Slim\Http\Response $res, $args) {

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
        'number_of_comments' => 5,
        'number_of_likes' => 10
    );


    $newRes = $res->withJson(
        $dummyResponse
    );

    return $newRes;
})->setName('post');