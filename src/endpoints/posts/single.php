<?php
/**
 * @api {get} /posts/:id/ Single Post
 * @apiName GetPost
 * @apiGroup Post
 *
 *
 * @apiSuccess {Number} 	id 				                ID of the Post
 * @apiSuccess {Number}	    reach				            Reach of the Post, measured in kilometers
 * @apiSuccess {Date}		date_posted		                Date when the Post was created
 *
 * @apiSuccess {Object[]}	comments
 * @apiSuccess {Number}	    comments.number_of_comments     Number of Comments on the Post
 * @apiSuccess {URL}	    comments.href                   Reference to the posts comments
 *
 * @apiSuccess {Object[]}	likes
 * @apiSuccess {Number}	    likes.number_of_likes           Number of Likes on the Post
 * @apiSuccess {URL}	    comments.href                   Reference to the posts likes
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
 *
 * @apiUse Unauthorized
 *
 * @apiUse NotFound
 *
 *
 *
 */

$app->get('/posts/{id}/', function( \Slim\Http\Request $req, \Slim\Http\Response $res, $args) {

    /** @var \Pixie\QueryBuilder\QueryBuilderHandler $qb */
    $qb = $this->querybuilder;



    $post = $qb->table('posts');

    $post->where('id', '=', $args['id']);

    $post->select( [
        'id',
        'authorid',
        'reach',
        'is_deleted',
        'latitude',
        'longitude',
        'date_posted',
        'content_type',
        'text',
        'image_src'
    ]);

    $responseData = $post->get();


    if( empty($responseData) ) {
        throw new \LocalFeud\Exceptions\NotFoundException('Post not found');
    } else {
        $responseData = $responseData[0];
    }



    // Format User
    $user = [
        'id' => $responseData->authorid,
        'href' => $this->get('router')->pathFor('user', [
            'id' => $responseData->authorid
        ])
    ];

    $responseData->user = $user;
    unset($responseData->authorid);




    // Format date_posted
    $d = new DateTime($responseData->date_posted);
    $responseData->date_posted = $d->format('c');



    // Format location
    $location = [
        'latitude' => $responseData->latitude,
        'longitude' => $responseData->longitude
    ];
    $responseData->location = $location;
    unset($responseData->latitude);
    unset($responseData->longitude);




    // Format is_deleted
    $responseData->is_deleted = boolval($responseData->is_deleted);



    // Format content
    if( $responseData->content_type == 'text') {
        $responseData->content = array(
            'type' => 'text',
            'text' => $responseData->text
        );
    }
    unset($responseData->content_type);
    unset($responseData->text);
    unset($responseData->image_src);






    // TODO Data not implemented yet
    $responseData->comments = [
        'number_of_comments' => 4,
        'href' => $this->get('router')->pathFor('postComments', [
            'id' => $args['id']
        ])
    ];



    // TODO Data not implemented yet
    $responseData->likes = [
        'number_of_likes' => 4,
        'href' => $this->get('router')->pathFor('postLikes', [
            'id' => $args['id']
        ])
    ];




    $newRes = $res->withJson(
        $responseData, null, JSON_NUMERIC_CHECK
    );

    return $newRes;
})->setName('post');