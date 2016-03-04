<?php

class Wrench_Exception_HandshakeException extends Wrench_Exception_Exception
{
    /**
     * @param string    $message
     * @param int       $code
     * @param Wrench_Exception_Exception $previous
     */
    public function __construct($message = null, $code = null, $previous = null)
    {
        if ($code == null) {
            $code = Wrench_Protocol_Protocol::HTTP_SERVER_ERROR;
        }
        parent::__construct($message, $code, $previous);
    }
}