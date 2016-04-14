<?php
namespace LocalFeud\Exceptions;
abstract class Exception extends \Exception {

    public function __construct($message, $code = null, \Exception $previous = null)
    {
        parent::__construct($message, $this->getStatus(), $previous);
    }

    /**
     * @return int
     */
    abstract function getStatus();
}