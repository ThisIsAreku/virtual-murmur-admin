<?php

namespace Vma\Domain\Murmur\Serializer\Handler;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use Vma\Domain\Murmur\Facade\ServerFacade;
use Vma\Domain\Murmur\Model\MurmurServer;

class ServerHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format'    => 'json',
                'type'      => 'Vma\Domain\Murmur\Model\MurmurServer',
                'method'    => 'serializeServerToJson',
            ],
        ];
    }

    public function serializeServerToJson(
        JsonSerializationVisitor $visitor,
        MurmurServer $server,
        array $type,
        Context $context
    )
    {
        return $visitor->getNavigator()->accept(
            new ServerFacade($server),
            ['name' => 'Vma\Domain\Murmur\Facade\ServerFacade'],
            $context
        );
    }
}
