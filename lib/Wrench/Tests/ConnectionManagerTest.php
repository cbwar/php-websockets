<?php


/**
 * Tests the ConnectionManager class
 */
class Wrench_Tests_ConnectionManagerTest extends Wrench_Tests_Test
{
    /**
     * @see Wrench\Tests.Wrench_Tests_Test::getClass()
     */
    protected function getClass()
    {
        return 'Wrench_ConnectionManager';
    }

    /**
     * Tests the constructor
     *
     * @dataProvider getValidConstructorArguments
     */
    public function testValidConstructorArguments($server, array $options)
    {
        $this->assertInstanceOfClass(
            $instance = $this->getInstance(
                $server,
                $options
            ),
            'Valid constructor arguments'
        );
    }

    /**
     * Tests the constructor
     */
    public function testConstructor()
    {
        $this->assertInstanceOfClass(
            $instance = $this->getInstance(
                $this->getMockServer(),
                array()
            ),
            'Constructor'
        );
        return $instance;
    }

    /**
     * @depends testConstructor
     * @param Wrench_ConnectionManager $instance
     */
    public function testCount($instance)
    {
        $this->assertTrue(is_numeric($instance->count()));
    }

    /**
     * Data provider
     */
    public function getValidConstructorArguments()
    {
        return array(
            array($this->getMockServer(), array())
        );
    }

    /**
     * Gets a mock server
     */
    protected function getMockServer()
    {
        $server = $this->getMock('Wrench_Server', array(), array(), '', false);

        $server->registerApplication('/echo', $this->getMockApplication());

        $server->expects($this->any())
                ->method('getUri')
                ->will($this->returnValue('ws://localhost:8000/'));

        return $server;
    }

    /**
     * Gets a mock application
     *
     * @return Wrench_Application_EchoApplication
     */
    protected function getMockApplication()
    {
        return new Wrench_Application_EchoApplication();
    }
}