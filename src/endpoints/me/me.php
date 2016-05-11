<?php

/**
* @api {get} /me/ What about me?
* @apiName Me
* @apiGroup User
*
 * @apiSuccess {Object[]}	user 				The User
 * @apiSuccess {Number}		user.id    	        ID of User
 * @apiSuccess {String}	    user.firstname      Firstname of User
 * @apiSuccess {String}	    user.lastname       Lastname of User
 * @apiSuccess {String}	    user.gender         Gender of User
 * @apiSuccess {Number}	    user.age            Age of User
*
* @apiUse Unauthorized
 * @apiUse NotFound
*/

use LocalFeud\Helpers\User;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/me/', function(Request $req, Response $res, $args) {

    /** @var \Pixie\QueryBuilder\QueryBuilderHandler $qb */
    $qb = $this->querybuilder;

    $me = $qb->table('users')->where('id', '=', User::getInstance()->getUserId());

    $me->select([
        'id',
        'firstname',
        'lastname',
        $qb->raw('sex as gender'),
        'birthday'
    ]);

    $me = $me->first();

    if( $me == null) {
        throw new \LocalFeud\Exceptions\NotFoundException("You dont exist");
    }

    $me->age = \LocalFeud\Helpers\Age::toAge( $me->birthday );
    unset($me->birthday);


    $res = $res->withJson( $me, null, JSON_NUMERIC_CHECK );
    return $res;
});