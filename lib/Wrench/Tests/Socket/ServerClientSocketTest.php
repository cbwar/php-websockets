<?php

class Wrench_Tests_Socket_ServerClientSocketTest extends Wrench_Tests_Socket_SocketTest
{
    public function getClass()
    {
        return 'Wrench_Socket_ServerClientSocket';
    }

    /**
     * By default, the socket has not required arguments
     */
    public function testConstructor()
    {
        $resource = null;
        $instance = $this->getInstance($resource);
        $this->assertInstanceOfClass($instance);
        return $instance;
    }

    /**
     * @expectedException Wrench_Exception_SocketException
     * @depends testConstructor
     */
    public function testGetIpTooSoon($instance)
    {
        $instance->getIp();
    }

    /**
     * @expectedException Wrench_Exception_SocketException
     * @depends testConstructor
     */
    public function testGetPortTooSoon($instance)
    {
        $instance->getPort();
    }
}