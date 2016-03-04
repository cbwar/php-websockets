<?php


/**
 * Tests the BasicServer class
 */
class Wrench_Tests_BasicServerTest extends Wrench_Tests_ServerTest
{
    /**
     * @see Wrench\Tests.Wrench_Tests_Test::getClass()
     */
    protected function getClass()
    {
        return 'Wrench_BasicServer';
    }

    /**
     * @param array $allowed
     * @param string $origin
     * @dataProvider getValidOrigins
     */
    public function testValidOriginPolicy(array $allowed, $origin)
    {
        $server = $this->getInstance('ws://localhost:8000', array(
            'allowed_origins' => $allowed,
            'logger' => array($this, 'log')
        ));

        $connection = $this->getMockBuilder('Wrench_Connection')
                        ->disableOriginalConstructor()
                        ->getMock();

        $connection
            ->expects($this->never())
            ->method('close')
            ->will($this->returnValue(true));

        $server->notify(
            Wrench_Server::EVENT_HANDSHAKE_REQUEST,
            array($connection, '', $origin, '', array())
        );
    }

    /**
     * @param array $allowed
     * @param string $origin
     * @dataProvider getInvalidOrigins
     */
    public function testInvalidOriginPolicy(array $allowed, $origin)
    {
        $server = $this->getInstance('ws://localhost:8000', array(
            'allowed_origins' => $allowed,
            'logger' => array($this, 'log')
        ));

        $connection = $this->getMockBuilder('Wrench_Connection')
                        ->disableOriginalConstructor()
                        ->getMock();

        $connection
            ->expects($this->once())
            ->method('close')
            ->will($this->returnValue(true));

        $server->notify(
            Wrench_Server::EVENT_HANDSHAKE_REQUEST,
            array($connection, '', $origin, '', array())
        );
    }

    /**
     * @see Wrench\Tests.ServerTest::getValidConstructorArguments()
     */
    public function getValidConstructorArguments()
    {
        return array_merge(parent::getValidConstructorArguments(), array(
            array(
                'ws://localhost:8000',
                array('logger' => function () {})
            )
        ));
    }

    /**
     * Data provider
     *
     * @return array<array<mixed>>
     */
    public function getValidOrigins()
    {
        return array(
            array(array('localhost'), 'localhost'),
            array(array('somewhere.com'), 'somewhere.com'),
        );
    }

    /**
     * Data provider
     *
     * @return array<array<mixed>>
     */
    public function getInvalidOrigins()
    {
        return array(
            array(array('localhost'), 'blah'),
            array(array('somewhere.com'), 'somewhereelse.com'),
            array(array('somewhere.com'), 'subdomain.somewhere.com')
        );
    }
}