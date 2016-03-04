<?php

/**
 * http://tools.ietf.org/html/draft-ietf-hybi-thewebsocketprotocol-10
 */
class Wrench_Protocol_Hybi10Protocol extends Wrench_Protocol_HybiProtocol
{
    const VERSION = 10;

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
        $version = (int)$version;

        if ($version <= 10 && $version >= 10) {
            return true;
        }
    }
}