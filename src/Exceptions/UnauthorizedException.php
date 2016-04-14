<?php
namespace LocalFeud\Exceptions;


class UnauthorizedException extends Exception {

    function getStatus() {
        return 401;
    }
}