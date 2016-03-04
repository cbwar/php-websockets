<?php


class Wrench_Tests_Listener_RateLimiterTest extends Wrench_Tests_Listener_ListenerTest
{
    /**
     * @see Wrench\Tests.Wrench_Tests_Test::getClass()
     */
    public function getClass()
    {
        return 'Wrench_Listener_RateLimiter';
    }

    /**
     * @see Wrench\Tests\Listener.ListenerTest::testConstructor()
     */
    public function testConstructor()
    {
        $instance = $this->getInstance();
        $this->assertInstanceOfClass($instance, 'No constructor arguments');
        return $instance;
    }

    public function testOnSocketConnect()
    {
        $this->getInstance()->onSocketConnect(null, $this->getConnection());
    }

    public function testOnSocketDisconnect()
    {
        $this->getInstance()->onSocketDisconnect(null, $this->getConnection());
    }

    public function testOnClientData()
    {
        $this->getInstance()->onClientData(null, $this->getConnection());
    }

    protected function getConnection()
    {
        $connection = $this->getMock('Wrench_Connection', array(), array(), '', false);

        $connection
            ->expects($this->any())
            ->method('getIp')
            ->will($this->returnValue('127.0.0.1'));

        $connection
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('abcdef01234567890'));

        $manager = $this->getMock('Wrench_ConnectionManager', array(), array(), '', false);
        $manager->expects($this->any())->method('count')->will($this->returnValue(5));

        $connection
            ->expects($this->any())
            ->method('getConnectionManager')
            ->will($this->returnValue($manager));

        return $connection;
    }
}