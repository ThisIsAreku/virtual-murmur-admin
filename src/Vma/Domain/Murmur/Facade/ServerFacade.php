<?php

namespace Vma\Domain\Murmur\Facade;

use JMS\Serializer\Annotation as Serializer;
use Vma\Domain\Murmur\Model\MurmurServer;

class ServerFacade
{
    /**
     * @Serializer\Type("integer")
     */
    public $id;

    /**
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @Serializer\Type("integer")
     */
    public $countUsers;

    /**
     * @Serializer\Type("integer")
     */
    public $maxUsers;

    /**
     * @Serializer\Type("integer")
     */
    public $uptime;

    /**
     * @Serializer\Type("integer")
     */
    public $logLen;

    public function __construct(MurmurServer $server) {
        $this->id         = $server->getId();
        $this->name       = $server->getName();
        $this->countUsers = $server->getCountUsers();
        $this->maxUsers   = $server->getMaxUsers();
        $this->uptime     = $server->getUptime();
        $this->logLen     = $server->getLogLen();
    }
}
