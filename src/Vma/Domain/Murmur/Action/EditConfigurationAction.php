<?php

namespace Vma\Domain\Murmur\Action;

use Vma\Domain\Murmur\Model\MurmurServer;

class EditConfigurationAction
{
    protected $serverId;
    protected $configuration;

    public function __construct($serverId, $configuration)
    {
        $this->serverId      = $serverId;
        $this->configuration = $configuration;
    }

    public function getServerId()
    {
        return $this->serverId;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }
}
