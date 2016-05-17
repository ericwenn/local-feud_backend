<?php

use LocalFeud\Exceptions\BadRequestException;
use LocalFeud\Helpers\User;
use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/gcm-register/', function(Request $req, Response $res, $args) {

    $userID = User::getInstance()->getUserId();
    $parameters = $req->getParsedBody();

    if( !isset($parameters['token']) ) {
        throw new BadRequestException("Token not set");
    }
    $gcm_token = $parameters['token'];


    /** @var \Pixie\QueryBuilder\QueryBuilderHandler $qb */
    $qb = $this->querybuilder;

    $user = $qb->table('users')->where('id', '=', $userID);
    $user->update(['gcm_token' => $gcm_token]);


    $response = $res->withJson([
        'status' => 200
    ]);

    return $response;

});