<?php

/**
 * Payload test
 */
abstract class Wrench_Tests_Payload_PayloadTest extends Wrench_Tests_Test
{
    /**
     * A fresh instance of the class being tested
     *
     * @var Wrench_Payload_Payload
     */
    protected $payload;

    /**
     * @see PHPUnit_Payloadwork_TestCase::setUp()
     */
    public function setUp()
    {
        parent::setUp();

        $this->payload = $this->getInstance();
    }

    /**
     * Tests the constructor
     */
    public function testConstructor()
    {
        $this->assertInstanceOfClass($this->getInstance());
    }

    /**
     * @param string $payload
     * @dataProvider getValidEncodePayloads
     */
    public function testBijection($type, $payload)
    {
        // Encode the payload
        $this->payload->encode($payload, $type);

        // Create a new payload and read the data in with encode
        $payload = $this->getInstance();
        $payload->encode($this->payload->getPayload(), $type);

        // These still match
        $this->assertEquals(
            $this->payload->getType(),
            $payload->getType(),
            'Types match after encode -> receiveData'
        );

        $this->assertEquals(
            $this->payload->getPayload(),
            $payload->getPayload(),
            'Payloads match after encode -> receiveData'
        );
    }

    /**
     * @param string $payload
     * @dataProvider getValidEncodePayloads
     */
    public function testEncodeTypeReflection($type, $payload)
    {
        $this->payload->encode($payload, Wrench_Protocol_Protocol::TYPE_TEXT);
        $this->assertEquals(Wrench_Protocol_Protocol::TYPE_TEXT, $this->payload->getType(), 'Encode retains type information');
    }

    /**
     * @param string $payload
     * @dataProvider getValidEncodePayloads
     */
    public function testEncodePayloadReflection($type, $payload)
    {
        $this->payload->encode($payload, Wrench_Protocol_Protocol::TYPE_TEXT);
        $this->assertEquals($payload, $this->payload->getPayload(), 'Encode retains payload information');
    }

    /**
     * Tests sending to a socket
     * @dataProvider getValidEncodePayloads
     */
    public function testSendToSocket($type, $payload)
    {
        $successfulSocket = $this->getMock('Wrench_Socket_ClientSocket', array(), array('wss://localhost:8000'));
        $failedSocket = clone $successfulSocket;

        $successfulSocket->expects($this->any())
                ->method('send')
                ->will($this->returnValue(true));

        $failedSocket->expects($this->any())
                ->method('send')
                ->will($this->returnValue(false));

        $this->payload->encode($payload, $type);

        $this->assertTrue($this->payload->sendToSocket($successfulSocket));
        $this->assertFalse($this->payload->sendToSocket($failedSocket));
    }

    /**
     * Tests receiving data
     * @dataProvider getValidEncodePayloads
     */
    public function testReceieveData($type, $payload)
    {
        $payload = $this->getInstance();
        $payload->receiveData($payload);
    }

    /**
     * Data provider
     *
     * @return array<string>
     */
    public function getValidEncodePayloads()
    {
        return array(
            array(
                Wrench_Protocol_Protocol::TYPE_TEXT,
                "123456\x007890!@#$%^&*()qwe\trtyuiopQWERTYUIOPasdfghjklASFGH\n
                JKLzxcvbnmZXCVBNM,./<>?;[]{}-=_+\|'asdad0x11\aasdassasdasasdsd"
            ),
            array(
                Wrench_Protocol_Protocol::TYPE_TEXT,
                pack('CCCCCCC', 0x00, 0x01, 0x02, 0x03, 0x04, 0xff, 0xf0)
            ),
            array(Wrench_Protocol_Protocol::TYPE_TEXT, ' ')
        );
    }
}