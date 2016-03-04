<?php

/**
 * Invalid origin exception
 */
class Wrench_Exception_InvalidOriginException extends Wrench_Exception_HandshakeException
{
    /**
     * @param string    $message
     * @param int       $code
     * @param Wrench_Exception_Exception $previous
     */
    public function __construct($message = null, $code = null, $previous = null)
    {
        if ($code == null) {
            $code = Wrench_Protocol_Protocol::HTTP_FORBIDDEN;
        }
        parent::__construct($message, $code, $previous);
    }
}
