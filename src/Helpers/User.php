<?php
/**
 * Created by PhpStorm.
 * User: ericwenn
 * Date: 5/3/16
 * Time: 3:53 PM
 */

namespace LocalFeud\Helpers;


class User {

    private $user_id;
    private $access_token;
    private $facebook_id;
    private static $instance = null;
    public static function setInstance($user_id, $access_token, $facebook_id) {
        self::$instance = new User($user_id, $access_token, $facebook_id);
    }

    private function __construct($user_id, $access_token, $facebook_id) {
        $this->user_id = $user_id;
        $this->access_token = $access_token;
        $this->facebook_id = $facebook_id;
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