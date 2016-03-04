<?php

class Wrench_Exception_BadRequestException extends Wrench_Exception_HandshakeException
{
    /**
     * @param string    $message
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($message = null, $code = null, $previous = null)
    {
        if ($code == null) {
            $code = Wrench_Protocol_Protocol::HTTP_BAD_REQUEST;
        }
        parent::__construct($message, $code, $previous);
    }
}