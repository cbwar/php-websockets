<?php

/**
 * Wrench Wrench_Server Wrench_Application_Application
 */
abstract class Wrench_Application_Application
{
    /**
     * Optional: handle a connection
     */
    // abstract public function onConnect($connection);

    /**
     * Optional: handle a disconnection
     *
     * @param
     */
	// abstract public function onDisconnect($connection);

    /**
     * Optional: allow the application to perform any tasks which will result in a push to clients
     */ 
    // abstract public function onUpdate();

    /**
     * Handle data received from a client
     *
     * @param Wrench_Payload_Payload $payload A payload object, that supports __toString()
     * @param Wrench_Connection $connection
     */
	abstract public function onData($payload, $connection);
}
