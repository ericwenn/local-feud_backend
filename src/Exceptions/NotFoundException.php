<?php
/**
 * Created by PhpStorm.
 * User: ericwenn
 * Date: 4/14/16
 * Time: 4:30 PM
 */

namespace LocalFeud\Exceptions;


class NotFoundException extends Exception {

    /**
     * @return int
     */
    function getStatus()
    {
        return 404;
    }
}