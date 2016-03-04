<?php


class Wrench_Tests_Frame_BadSubclassFrame extends Wrench_Frame_HybiFrame
{
    protected $payload = 'asdmlasdkm';
    protected $buffer = false;
}

class Wrench_Tests_Frame_BadSubclassFrameTest extends Wrench_Tests_Test
{
    /**
     * @expectedException Wrench_Exception_FrameException
     */
    public function testInvalidFrameBuffer()
    {
        $frame = new Wrench_Tests_Frame_BadSubclassFrame();
        $frame->getFrameBuffer();
    }

    protected function getClass()
    {
        return 'Wrench_Tests_Frame_BadSubclassFrame';
    }
}
