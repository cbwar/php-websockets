<?php


/**
 * Payload test
 */
abstract class Wrench_Tests_Listener_ListenerTest extends Wrench_Tests_Test
{
    /**
     * @depends testConstructor
     */
    public function testListen($instance)
    {
        $server = $this->getMock('Wrench_Server', array(), array(), '', false);

        $instance->listen($server);
    }

    abstract public function testConstructor();
}