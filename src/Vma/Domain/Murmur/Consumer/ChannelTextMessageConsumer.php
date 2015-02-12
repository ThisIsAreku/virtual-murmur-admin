<?php

namespace Vma\Domain\Murmur\Consumer;

use Swarrot\Broker\Message;
use Swarrot\Processor\ProcessorInterface;
use Vma\Domain\Murmur\Model\MurmurMeta;

class ChannelTextMessageConsumer implements ProcessorInterface
{

    private $murmurMeta;

    public function __construct(MurmurMeta $murmurMeta)
    {
        $this->murmurMeta = $murmurMeta;
    }

    /**
     * process
     *
     * @param Message $message The message given by a MessageProvider
     * @param array   $options An array containing all parameters
     *
     * @return boolean
     */
    public function process(Message $message, array $options)
    {
        $data = json_decode($message->getBody(), true);
    }
}