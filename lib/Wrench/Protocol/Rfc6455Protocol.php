<?php

/**
 * This is the version of websockets used by Chrome versions 17 through 19.
 *
 * @see http://tools.ietf.org/html/rfc6455
 */
class Wrench_Protocol_Rfc6455Protocol extends Wrench_Protocol_HybiProtocol
{
    const VERSION = 13;

    /**
     * @see Wrench_Protocol_Protocol::getVersion()
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * This is our most recent protocol class
     *
     * @see Wrench_Protocol_Protocol::acceptsVersion()
     */
    public function acceptsVersion($version)
    {
        if ((int)$version <= 13) {
            return true;
        }
        return false;
    }
}