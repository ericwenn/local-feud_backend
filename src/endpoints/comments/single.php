<?php

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @api {delete} /comments/:id/ Delete Comment
 * @apiGroup Comment
 *
 * @apiParam {Number}       id                              ID of Comment
 *
 * @apiUse Unauthorized
*/
$app->delete('/comments/{id}/', function(Request $req, Response $res, $args) {

    /** @var \Pixie\QueryBuilder\QueryBuilderHandler $qb */
    $qb = $this->querybuilder;

    $comment = $qb->table('comments')->where('id', '=', $args['id']);
    $comment->delete();



    $res = $res->withJson(
        [
            'status' => 200
        ]
    );
    return $res;
});