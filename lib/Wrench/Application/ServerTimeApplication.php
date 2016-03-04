<?php

/**
 * Example application demonstrating how to use Wrench_Application_Application::onUpdate
 *
 * Pushes the server time to all clients every update tick.
 */
class Wrench_Application_ServerTimeApplication extends Wrench_Application_Application
{
    protected $clients = array();
    protected $lastTimestamp = null;

    /**
     * @see Wrench_Application_Application::onConnect()
     */
    public function onConnect($client)
    {
        $this->clients[] = $client;
    }

    /**
     * @see Wrench_Application_Application::onUpdate()
     */
    public function onUpdate()
    {
        // limit updates to once per second
        if(time() > $this->lastTimestamp) {
            $this->lastTimestamp = time();

            foreach ($this->clients as $sendto) {
                $sendto->send(date('d-m-Y H:i:s'));
            }
        }
    }

    /**
     * Handle data received from a client
     *
     * @param Wrench_Payload_Payload    $payload A payload object, that supports __toString()
     * @param Wrench_Connection $connection
     */
    public function onData($payload, $connection)
    {
        return;
    }
}
