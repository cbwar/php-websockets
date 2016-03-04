<?php


/**
 * Tests the client class
 */
class Wrench_Tests_ClientTest extends Wrench_Tests_Test
{
    /**
     * @see Wrench\Tests.Wrench_Tests_Test::getClass()
     */
    protected function getClass()
    {
        return 'Wrench_Client';
    }

    public function testConstructor()
    {
        $this->assertInstanceOfClass(
            $client = new Wrench_Client(
                'ws://localhost/test', 'http://example.org/'
            ),
            'ws:// scheme, default socket'
        );

        $this->assertInstanceOfClass(
            $client = new Wrench_Client(
                'ws://localhost/test', 'http://example.org/',
                array('socket' => $this->getMockSocket())
            ),
            'ws:// scheme, socket specified'
        );
    }

    /**
     * Gets a mock socket
     *
     * @return Wrench_Socket_Socket
     */
    protected function getMockSocket()
    {
        return $this->getMock('Wrench_Socket_ClientSocket', array(), array('wss://localhost:8000'));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testConstructorSocketUnspecified()
    {
        $w = new Wrench_Client();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorUriInvalid()
    {
        $w = new Wrench_Client('invalid uri', 'http://www.example.com/');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorUriEmpty()
    {
        $w = new Wrench_Client(null, 'http://www.example.com/');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorUriPathUnspecified()
    {
        $w = new Wrench_Client('ws://localhost', 'http://www.example.com/');
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testConstructorOriginUnspecified()
    {
        $w = new Wrench_Client('ws://localhost');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorOriginEmpty()
    {
        $w = new Wrench_Client('wss://localhost', null);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorOriginInvalid()
    {
        $w = new Wrench_Client('ws://localhost:8000', 'NOTAVALIDURI');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSendInvalidType()
    {
        $client = new Wrench_Client('ws://localhost/test', 'http://example.org/');
        $client->sendData('blah', 9999);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSendInvalidTypeString()
    {
        $client = new Wrench_Client('ws://localhost/test', 'http://example.org/');
        $client->sendData('blah', 'fooey');
    }

    public function testSend()
    {
        try {
            $helper = new Wrench_Tests_ServerTestHelper();
            $helper->setUp();

            /* @var $instance Wrench_Client */
            $instance = $this->getInstance($helper->getEchoConnectionString(), 'http://www.example.com/send');
            $instance->addRequestHeader('X-Wrench_Tests_Test', 'Custom Request Header');

            $this->assertFalse($instance->receive(), 'Receive before connect');

            $success = $instance->connect();
            $this->assertTrue($success, 'Client can connect to test server');
            $this->assertTrue($instance->isConnected());

            $this->assertFalse($instance->connect(), 'Double connect');

            $this->assertFalse((boolean)$instance->receive(), 'No data');

            $bytes = $instance->sendData('foobar', 'text');
            $this->assertTrue($bytes >= 6, 'sent text frame');
            sleep(1);

            $bytes = $instance->sendData('baz', Wrench_Protocol_Protocol::TYPE_TEXT);
            $this->assertTrue($bytes >= 3, 'sent text frame');
            sleep(1);

            $responses = $instance->receive();
            $this->assertTrue(is_array($responses));
            $this->assertCount(2, $responses);
            $this->assertInstanceOf('Wrench_Payload_Payload', $responses[0]);
            $this->assertInstanceOf('Wrench_Payload_Payload', $responses[1]);

            $bytes = $instance->sendData('baz', Wrench_Protocol_Protocol::TYPE_TEXT);
            $this->assertTrue($bytes >= 3, 'sent text frame');
            sleep(1);

            # test fix for issue #43
            $responses = $instance->receive();
            $this->assertTrue(is_array($responses));
            $this->assertCount(1, $responses);
            $this->assertInstanceOf('Wrench_Payload_Payload', $responses[2]);

            $instance->disconnect();

            $this->assertFalse($instance->isConnected());
        } catch (Exception $e) {
            $helper->tearDown();
            throw $e;
        }

        $helper->tearDown();
    }
}
