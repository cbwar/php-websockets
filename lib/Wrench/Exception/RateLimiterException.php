<?php


class Wrench_Exception_RateLimiterException extends Wrench_Exception_Exception
{
    /**
     * @param string    $message
     * @param int       $code
     * @param Wrench_Exception_Exception $previous
     */
    public function __construct($message = null, $code = null, $previous = null)
    {
        if ($code == null) {
            $code = Wrench_Protocol_Protocol::CLOSE_GOING_AWAY;
        }
        parent::__construct($message, $code, $previous);
    }
}
