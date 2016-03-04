<?php


/**
 * @see http://tools.ietf.org/html/rfc6455#section-5.2
 */
abstract class Wrench_Protocol_HybiProtocol extends Wrench_Protocol_Protocol
{
    /**
     * @see Wrench_Protocol_Protocol::getPayload()
     */
    public function getPayload()
    {
        return new Wrench_Payload_HybiPayload();
    }
}