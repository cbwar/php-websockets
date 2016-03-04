<?php


class Wrench_Tests_Application_EchoApplicationTest extends Wrench_Tests_Test
{
    /**
     * @see Wrench\Tests.Wrench_Tests_Test::getClass()
     */
    protected function getClass()
    {
        return 'Wrench_Application_EchoApplication';
    }

    /**
     * Tests the constructor
     */
    public function testConstructor()
    {
        $this->assertInstanceOfClass($this->getInstance());
    }

    /**
     * @param unknown_type $payload
     * @dataProvider getValidPayloads
     */
    public function testOnData($payload)
    {
        $connection = $this->getMockBuilder('Wrench_Connection')
                     ->disableOriginalConstructor()
                     ->getMock();

        $connection
            ->expects($this->once())
            ->method('send')
            ->with($this->equalTo($payload), $this->equalTo(Wrench_Protocol_Protocol::TYPE_TEXT))
            ->will($this->returnValue(true));

        $this->getInstance()->onData($payload, $connection);
    }

    /**
     * Data provider
     *
     * @return array<array<string>>
     */
    public function getValidPayloads()
    {
        return array(
            array('asdkllakdaowidoaw noaoinosdna nwodinado ndsnd aklndiownd'),
            array(' ')
        );
    }
}