<?php

namespace Vma\Domain\Murmur\Action;

use Vma\Domain\Murmur\Model\MurmurServer;

class ChannelMessageAction
{
    protected $message;
    protected $channelIds;
    protected $server;
    protected $recursive;
    protected $async;

    public function __construct(MurmurServer $server)
    {
        $this->server      = $server;
        $this->recursive   = false;
        $this->async       = false;
        $this->channelIds  = [];
    }

    public function getServer()
    {
        return $this->server;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function getChannelIds()
    {
        return $this->channelIds;
    }

    public function setChannelIds(array $channelIds)
    {
        $this->channelIds = $channelIds;

        return $this;
    }

    public function isRecursive()
    {
        return $this->recursive;
    }

    public function setRecursive($recursive)
    {
        $this->recursive = (bool)$recursive;

        return $this;
    }

    public function isAsync()
    {
        return $this->async;
    }

    public function setAsync($async)
    {
        $this->async = (bool)$async;

        return $this;
    }
}
