<?php
/**
 * @api {get} /posts/:id/likes/ Likes on a Post
 * @apiGroup Like
 *
 * @apiParam {Number}       id                          ID of Post
 * 
 * @apiSuccess {Object[]}	likes 					    The Likes
 * @apiSuccess {Date}		likes.date_liked    	    Date when the Post was liked
 * @apiSuccess {Number}	    likes.is_original_poster    If the User is also the Author of the Post
 *
 * @apiSuccess {Object[]}	likes.user 			        The User who created the Post
 * @apiSuccess {String}	    likes.user.firstname		Firstname of the User
 * @apiSuccess {String}	    likes.user.lastname 	    Lastname of the User
 * @apiSuccess {Number}		likes.user.id 		        ID of the User
 * @apiSuccess {URL}		likes.user.href 		    Reference to the endpoint
 */
use LocalFeud\Helpers\NameGenerator;
use LocalFeud\Helpers\User;

$app->get('/posts/{id}/likes/', function($req, $res, $args) {

    /** @var \Pixie\QueryBuilder\QueryBuilderHandler $qb */
    $qb = $this->querybuilder;
    NameGenerator::setQB( $qb );


    $likes = $qb->table('likes')->where('likes.postid', '=', $args['id']);


    $likes->leftJoin('post_commentators', function(\Pixie\QueryBuilder\JoinBuilder $table) {
        $table->on('likes.postid', '=', 'post_commentators.postid');
        $table->on('likes.userid', '=', 'post_commentators.userid');
    });


    $likes->leftJoin('posts', 'likes.postid', '=', 'posts.id');


    $likes->select(
        [
            'posts.authorid',
            'likes.userid',
            'likes.postid',
            'post_commentators.firstname',
            'post_commentators.lastname',
            'likes.date_created'
        ]
    );



    $responseData = $likes->get();

    foreach($responseData as &$like) {


        // Format is_original_poster
        $like->is_original_poster = $like->authorid == $like->userid;






        // Format user
        if( $like->firstname == null && $like->lastname == null) {
            list($firstname, $lastname) = NameGenerator::generate($like->postid, $like->userid);
            $like->firstname = $firstname;
            $like->lastname = $lastname;
        }

        $user = array(
            'id' => $like->userid,
            'firstname' => $like->firstname,
            'lastname' => $like->lastname,
            'href' => $this->get('router')->pathFor('user', array(
                'id' => $like->userid
            ))
        );
        $like->user = $user;


        unset($like->firstname);
        unset($like->lastname);
        unset($like->userid);
        unset($like->authorid);






        // Format date liked
        $d = new DateTime( $like->date_created );
        $like->date_liked = $d->format('c');
        
        unset($like->date_created);
        unset($like->postid);


    }



    $newRes = $res->withJson(
       $responseData, null, JSON_NUMERIC_CHECK
    );

    return $newRes;
})->setName('postLikes');






/**
 * @api {post} /posts/:id/likes/ Like a Post
 * @apiGroup Like
 *
 * @apiParam {Number} id        ID of Post
 *
 * @apiUse Unauthorized
 * @apiUse NotFound
 */



$app->post('/posts/{id}/likes/', function( \Slim\Http\Request $req, \Slim\Http\Response $res, $args ) {

    /** @var \Pixie\QueryBuilder\QueryBuilderHandler $qb */
    $qb = $this->querybuilder;

    $userID = User::getInstance()->getUserId();
    $postID = $args['id'];



    $likeCheck = $qb->table('likes');

    $likeCheck->where( 'userid', '=', $userID );
    $likeCheck->where( 'postid', '=', $postID );

    if( $likeCheck->count() === 0 ) {

        $likes = $qb->table('likes');
        $likes->insert( [
            'userid' => $userID,
            'postid' => $postID
        ]);
    }


    $newRes = $res->withJson(
        [
            'status' => 200
        ], null, JSON_NUMERIC_CHECK
    );

    return $newRes;

});





/**
 * @api {delete} /posts/:id/likes/ Remove Like on Post
 * @apiGroup Like
 *
 * @apiParam {Number} id        ID of Post
 *
 * @apiUse Unauthorized
 * @apiUse NotFound
 */

$app->delete('/posts/{id}/likes/', function(\Slim\Http\Request $req, \Slim\Http\Response $res, $args) {


    /** @var \Pixie\QueryBuilder\QueryBuilderHandler $qb */
    $qb = $this->querybuilder;

    $userID = User::getInstance()->getUserId();
    $postID = $args['id'];


    $likes = $qb->table('likes');

    $likes->where( 'userid', '=', $userID );
    $likes->where( 'postid', '=', $postID );

    $likes->delete();


    $newRes = $res->withJson(
        [
            'status' => 200
        ], null, JSON_NUMERIC_CHECK
    );

    return $newRes;

});


