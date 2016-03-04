<?php


/**
 * Wrench_Util_Configurable base class
 */
abstract class Wrench_Util_Configurable
{
    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var Wrench_Protocol_Protocol
     */
    protected $protocol;

    /**
     * Wrench_Util_Configurable constructor
     *
     * @param array  $options (optional)
     *   Options:
     *     - protocol             => Wrench_Protocol_Protocol object, latest protocol
     *                                 version used if not specified
     */
    public function __construct(
        array $options = array()
    ) {
        $this->configure($options);
        $this->configureProtocol();
    }

    /**
     * Configures the options
     *
     * @param array $options
     */
    protected function configure(array $options)
    {
        $this->options = array_merge(array(
            'protocol' => new Wrench_Protocol_Rfc6455Protocol()
        ), $options);
    }

    /**
     * Configures the protocol option
     *
     * @throws InvalidArgumentException
     */
    protected function configureProtocol()
    {
        $protocol = $this->options['protocol'];

        if (!$protocol || !($protocol instanceof Wrench_Protocol_Protocol)) {
            throw new InvalidArgumentException('Invalid protocol option');
        }

        $this->protocol = $protocol;
    }
}