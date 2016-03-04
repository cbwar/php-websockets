<?php


/**
 * Close connection exception
 */
class Wrench_Exception_CloseException extends Wrench_Exception_Exception
{
    /**
     * @param string    $message
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($message = null, $code = null, $previous = null)
    {
        if ($code == null) {
            $code = Wrench_Protocol_Protocol::CLOSE_UNEXPECTED;
        }
        parent::__construct($message, $code, $previous);
    }
}