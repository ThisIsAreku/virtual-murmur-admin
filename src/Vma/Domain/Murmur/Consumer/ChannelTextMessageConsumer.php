<?php

namespace Vma\Domain\Murmur\Consumer;

use Psr\Log\LoggerInterface;
use Swarrot\Broker\Message;
use Swarrot\Processor\ProcessorInterface;
use Vma\Domain\Murmur\Model\MurmurMeta;

class ChannelTextMessageConsumer implements ProcessorInterface
{

    private $murmurMeta;
    private $logger;

    public function __construct(MurmurMeta $murmurMeta, LoggerInterface $logger)
    {
        $this->murmurMeta = $murmurMeta;
        $this->logger     = $logger;
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
        var_dump($data);

        if (empty($data['message'])) {
            $this->logger and $this->logger->warn("Dropped empty message", $data);
            return false;
        }

        $serverId  = empty($data['server_id']) ? 1 : intval($data['server_id']);
        $channelId = empty($data['channel_id']) ? 1 : intval($data['channel_id']);
        $tree      = empty($data['tree']) ? false : intval($data['server_id']);

        /** @type MurmurServer $server */
        $server = null;
        try {
            $server = $this->murmurMeta->getServer($serverId);
        } catch (\Exception $e) {
            $this->logger and $this->logger->error("Cannot connect to server", ['exception' => $e, 'data' => $data]);
            return false;
        }
        var_dump([
            $channelId, $tree, $data['message']
        ]);

        $server->sendMessageChannel($channelId, $tree, $data['message']);
    }
}
