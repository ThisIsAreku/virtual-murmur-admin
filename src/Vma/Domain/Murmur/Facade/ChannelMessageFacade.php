<?php

namespace Vma\Domain\Murmur\Facade;

use JMS\Serializer\Annotation as Serializer;
use Vma\Domain\Murmur\Action\ChannelMessageAction;

class ChannelMessageFacade
{
    /**
     * @Serializer\Type("integer")
     */
    public $serverId;

    /**
     * @Serializer\Type("integer")
     */
    public $channelId;

    /**
     * @Serializer\Type("string")
     */
    public $message;

    /**
     * @Serializer\Type("boolean")
     */
    public $recursive;

    public function __construct(ChannelMessageAction $channelMessage) {
        $this->serverId  = $channelMessage->getServer()->getId();
        $this->channelId = $channelMessage->getChannelIds()[0];
        $this->message   = $channelMessage->getMessage();
        $this->recursive = $channelMessage->isRecursive();
    }
}
