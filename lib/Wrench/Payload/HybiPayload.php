<?php


/**
 * Gets a HyBi payload
 * @author Dominic
 *
 */
class Wrench_Payload_HybiPayload extends Wrench_Payload_Payload
{
    /**
     * @see Wrench_Payload_Payload::getFrame()
     */
    protected function getFrame()
    {
        return new Wrench_Frame_HybiFrame();
    }
}