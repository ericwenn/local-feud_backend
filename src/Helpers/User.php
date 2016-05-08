<?php
/**
 * Created by PhpStorm.
 * User: ericwenn
 * Date: 5/3/16
 * Time: 3:53 PM
 */

namespace LocalFeud\Helpers;


use Facebook\Facebook;
use Facebook\FacebookResponse;
use Facebook\GraphNodes\GraphUser;
use Pixie\QueryBuilder\QueryBuilderHandler;

class User {

    private $user_id;
    private $access_token;
    private $facebook_id;
    private static $instance = null;
    /* @var $qb QueryBuilderHandler */
    private $qb;

    /* @var $fb Facebook */
    private $fb;

    /* @var $graphUser GraphUser */
    private $graphUser;

    public static function setInstance($facebook_user_id, $access_token, QueryBuilderHandler $qb, Facebook $fb) {
        self::$instance = new User($facebook_user_id, $access_token, $qb, $fb);
    }

    private function __construct($facebook_user_id, $access_token, $qb, $fb) {
        $this->access_token = $access_token;
        $this->facebook_id = $facebook_user_id;
        $this->qb = $qb;
        $this->fb = $fb;


        $this->checkValidityOfToken();
        $this->updateDatabase();
    }

    /**
     * @return User
     */
    public static function getInstance() {
        if( self::$instance == null) {
            throw new \RuntimeException('User-instance not set');
        }
        return self::$instance;
    }




    private function checkValidityOfToken() {
        try {
            /** @var FacebookResponse $fb_response */
            $fb_response = $this->fb->get('/me?fields=name,gender,age_range,birthday', $this->access_token);
            /** @var GraphUser $graphUser */
            $this->graphUser = $fb_response->getGraphUser();
        } catch (FacebookResponseException $e) {
            // If the token isnt valid, throw unatohrized
            throw new UnauthorizedException('Accesstoken not valid');
        }


        // Check if the provided user id is the same as token owner
        if( $this->graphUser->getId() != $this->facebook_id) {
            throw new UnauthorizedException('User id does not match token');
        }



    }


    private function updateDatabase() {
        // Check if the user is in our database already
        $dbUser = $this->qb->table('users');
        $dbUser->where('facebook_user_id', '=', $this->facebook_id);

        $dbUser = $dbUser->get();

        if(sizeof($dbUser) > 0) {

            // If the user exists, but token is not the same: update token
            if( $this->access_token != $dbUser[0]->facebook_access_token) {

                $this->qb->table('users')->where('id', '=', $dbUser[0]->id)->update([
                    'facebook_access_token' => $this->access_token
                ]);
                $dbUser[0]->facebook_access_token = $this->access_token;
            }


            // Update date of birth and gender from Facebook Graph
            $this->qb->table('users')->where('id', '=', $dbUser[0]->id)->update([
                'sex' => $this->graphUser->getGender(),
                'birthday' => $this->graphUser->getBirthday()->format('U')
            ]);

            // Save user id
            $this->user_id = $dbUser[0]->id;

        } else {
            // If the user doesnt exist, insert in db with token and save user id
            $this->user_id = $this->qb->table('users')->insert([
                'facebook_user_id' => $this->facebook_id,
                'facebook_access_token' => $this->access_token,
                'sex' => $this->graphUser->getGender(),
                'birthday' => $this->graphUser->getBirthday()->format('U')
            ]);

        }

    }





    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }



}