<?php
namespace LocalFeud\Helpers;
use Nubs\RandomNameGenerator\Alliteration;
use Pixie\QueryBuilder\QueryBuilderHandler;

/**
 * Class NameGenerator
 * @package LocalFeud\Helpers
 * Adapter for the name generator. When a new name is generated it will be put into the database after script finishes execution.
 */
class NameGenerator {
    private static
        $generator = null,
        $isHooked = false,
        $insertQueue = array(),
        $queryBuilder= null;


    public static function setQB( QueryBuilderHandler $qb) {
        self::$queryBuilder = $qb;
    }

    public static function generator() {
        if( self::$generator == null) {
            self::$generator = new Alliteration();
        }

        return self::$generator;
    }

    /**
     * Registers the shutdown function
     */
    public static function hook() {
        if( !self::$isHooked ) {
            register_shutdown_function( array(__CLASS__, 'onShutdown') );
            self::$isHooked = true;
        }
    }


    /**
     * Inserts into database
     */
    public static function onShutdown() {
        if( !self::$queryBuilder == null && !empty(self::$insertQueue)) {
            $i = self::$queryBuilder->table('post_commentators');
            $i->insert(self::$insertQueue);
        }
    }

    /**
     * Generates a new name, and puts in database queue
     * @param $postid int
     * @param $userid int
     * @return array firstname and lastname
     *
     */
    public static function generate($postid, $userid) {
        self::hook();

        if( self::$queryBuilder == null) {
            throw new \RuntimeException('NameGenerator is not set');
        }

        $full_name = explode(' ', self::generator()->getName());

        self::enqueue($postid, $userid, $full_name[0], $full_name[1]);

        return $full_name;
    }


    public static function enqueue( $postid, $userid, $firstname, $lastname ) {
        self::$insertQueue[] = array(
            'postid' => $postid,
            'userid' => $userid,
            'firstname' => $firstname,
            'lastname' => $lastname
        );
    }
}