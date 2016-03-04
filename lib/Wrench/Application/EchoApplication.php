<?php

/**
 * Example application for Wrench: echo server
 */
class Wrench_Application_EchoApplication extends Wrench_Application_Application
{
    /**
     * @see Wrench_Application_Application::onData()
     */
    public function onData($data, $client)
    {
        $client->send($data);
    }
}