<?php

namespace Vma\Domain\Murmur\Consumer;

use Swarrot\Broker\Message;
use Swarrot\Processor\ProcessorInterface;
use Vma\Domain\Murmur\Model\MurmurMeta;
use Vma\Domain\Murmur\Model\MurmurServer;

class UserTextMessageConsumer implements ProcessorInterface
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

        if (empty($data['message'])) {
            return;
        }

        $serverId = empty($data['server_id']) ? 1 : intval($data['server_id']);

        /** @var MurmurServer $server */
        $server = null;
        try {
            $server = $this->murmurMeta->getServer($serverId);
        } catch (\Exception $e) {
            return;
        }

        $target_sessions = [];

        if (isset($data['user_names'])) {
            $userNames = $data['user_names'];
            if (!is_array($userNames)) {
                $userNames = [$userNames];
            }

            $userNames = $server->getConnectedUsersByUserNames($userNames);
            $target_sessions = array_merge($target_sessions, array_values($userNames));
        }

        if (isset($data['user_ids'])) {
            $userIds = $data['user_ids'];
            if (!is_array($userIds)) {
                $userIds = [$userIds];
            }

            $userIds = $server->getConnectedUsersByIds($userIds);
            $target_sessions = array_merge($target_sessions, array_values($userIds));
        }

        if (isset($data['user_sessions'])) {
            $sessions = $data['user_sessions'];
            if (!is_array($sessions)) {
                $sessions = [$sessions];
            }

            $target_sessions = array_merge($target_sessions, $sessions);
        }

        foreach ($target_sessions as $session) {
            $server->sendMessage($session, $data['message']);
        }
    }
}