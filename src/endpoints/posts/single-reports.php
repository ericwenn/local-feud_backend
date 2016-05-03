<?php
/**
 * @api {post} /posts/:id/reports/ Report a post
 * @apiGroup Report
 *
 * @apiParam {Number} id        ID of Post
 *
 * @apiUse Unauthorized
 * @apiUse NotFound
 */

use LocalFeud\Helpers\User;

$app->post('/posts/{id}/reports/', function(\Slim\Http\Request $req, \Slim\Http\Response $res, $args ) {

    /** @var \Pixie\QueryBuilder\QueryBuilderHandler $qb */
    $qb = $this->querybuilder;

    // TODO Authenticated used instead of this
    $userID = User::getInstance()->getUserId();
    $postID = $args['id'];



    $likeCheck = $qb->table('reports');

    $likeCheck->where( 'reporterid', '=', $userID );
    $likeCheck->where( 'postid', '=', $postID );

    if( $likeCheck->count() === 0 ) {

        $likes = $qb->table('reports');
        $likes->insert( [
            'reporterid' => $userID,
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
 * @api {delete} /posts/:id/reports/ Unreport a post
 * @apiGroup Report
 *
 * @apiParam {Number} id        ID of Post
 *
 * @apiUse Unauthorized
 * @apiUse NotFound
 */


$app->delete('/posts/{id}/reports/', function(\Slim\Http\Request $req, \Slim\Http\Response $res, $args) {


    /** @var \Pixie\QueryBuilder\QueryBuilderHandler $qb */
    $qb = $this->querybuilder;

    $userID = User::getInstance()->getUserId();
    $postID = $args['id'];


    $likes = $qb->table('reports');

    $likes->where( 'reporterid', '=', $userID );
    $likes->where( 'postid', '=', $postID );

    $likes->delete();


    $newRes = $res->withJson(
        [
            'status' => 200
        ], null, JSON_NUMERIC_CHECK
    );

    return $newRes;

});


