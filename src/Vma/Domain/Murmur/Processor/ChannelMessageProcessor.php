<?php

namespace Vma\Domain\Murmur\Processor;

use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Swarrot\Broker\Message;
use Swarrot\SwarrotBundle\Broker\Publisher;
use Vma\Domain\Murmur\Action\ChannelMessageAction;
use Vma\Domain\Murmur\Facade\ChannelMessageFacade;
use Vma\Domain\Murmur\Model\MurmurMeta;

class ChannelMessageProcessor
{
    private $messagePublisher;
    private $serializer;
    private $logger;

    public function __construct(SerializerInterface $serializer, Publisher $messagePublisher, LoggerInterface $logger)
    {
        $this->serializer       = $serializer;
        $this->messagePublisher = $messagePublisher;
        $this->logger           = $logger;
    }

    public function execute(ChannelMessageAction $action)
    {
         if ($action->isAsync()) {
            $messageFacade = new ChannelMessageFacade($action);
            foreach ($action->getChannelIds() as $channelId) {
                $messageFacade->channelId = $channelId;
                $this->messagePublisher->publish('channel_text_message', 
                    new Message($this->serializer->serialize($messageFacade, 'json'))
                );
            }

            return true;
        } else {
            $has_error = false;
            foreach ($action->getChannelIds() as $channelId) {
                try {
                    $action->getServer()->sendMessageChannel($channelId, $action->isRecursive(), $action->getMessage());
                } catch (\Exception $e) {
                    $has_error = true;
                    $this->logger->error('Cannot post message', ['exception' => $e, 'channelId' => $channelId, 'action' => $action]);
                }
            }

            return !$has_error;
        }
    }
}
