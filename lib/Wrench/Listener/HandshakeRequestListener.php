<?php

interface Wrench_Listener_HandshakeRequestListener
{
    /**
     * Handshake request listener
     *
     * @param Wrench_Connection $connection
     * @param string $path
     * @param string $origin
     * @param string $key
     * @param array $extensions
     */
    public function onHandshakeRequest(Wrench_Connection $connection, $path, $origin, $key, $extensions);
}