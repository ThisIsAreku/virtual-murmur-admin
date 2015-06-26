<?php

namespace Vma\Domain\Murmur\Processor;

use Psr\Log\LoggerInterface;
use Vma\Domain\Murmur\Action\EditConfigurationAction;
use Vma\Domain\Murmur\Model\MurmurMeta;

class EditConfigurationProcessor
{
    private $murmurMeta;
    private $logger;

    public function __construct(MurmurMeta $murmurMeta, LoggerInterface $logger)
    {
        $this->murmurMeta = $murmurMeta;
        $this->logger     = $logger;
    }

    public function execute(EditConfigurationAction $action)
    {
        $server = $this->murmurMeta->getServer($action->getServerId());

        foreach ($action->getConfiguration() as $key => $value) {
            if ($server->getConf($key) !== $value) {
                $server->setConf($key, $value);
            }
        }
    }
}
