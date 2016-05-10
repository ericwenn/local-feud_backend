<?php
/**
 * Created by PhpStorm.
 * User: ericwenn
 * Date: 5/10/16
 * Time: 11:28 AM
 */

namespace LocalFeud\Helpers;


use DateTime;

class Age
{
    public static function toAge( $date ) {
        if( $date == null ) {
            return null;
        }
        $then = new DateTime($date);
        $now = new DateTime();
        $age = $now->diff( $then );
        return $age->y;
    }
}