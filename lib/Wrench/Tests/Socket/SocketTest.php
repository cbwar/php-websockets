<?php


abstract class Wrench_Tests_Socket_SocketTest extends Wrench_Tests_Test
{
    /**
     * Require constructor testing
     */
    abstract public function testConstructor();

    /**
     * @depends testConstructor
     */
    public function testIsConnected($instance)
    {
        $connected = $instance->isConnected();
        $this->assertTrue(is_bool($connected), 'isConnected returns boolean');
        $this->assertFalse($connected);
    }

    /**
     * @dataProvider getValidNames
     * @param string $name
     */
    public function testGetNamePart($name, $ip, $port)
    {
        $this->assertEquals($ip, Wrench_Socket_Socket::getNamePart($name, Wrench_Socket_Socket::NAME_PART_IP), 'splits ip correctly');
        $this->assertEquals($port, Wrench_Socket_Socket::getNamePart($name, Wrench_Socket_Socket::NAME_PART_PORT), 'splits port correctly');
    }

    /**
     * Data provider
     */
    public function getValidNames()
    {
        return array(
            array('127.0.0.1:52339', '127.0.0.1', '52339'),
            array('255.255.255.255:1025', '255.255.255.255', '1025'),
            array('::1:56670', '::1', '56670')
        );
    }
}