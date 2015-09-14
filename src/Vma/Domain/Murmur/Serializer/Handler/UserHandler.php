<?php


namespace Vma\Domain\Murmur\Serializer\Handler;


use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use Vma\Domain\Murmur\Facade\UserFacade;

class UserHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format'    => 'json',
                'type'      => 'Murmur_User',
                'method'    => 'serializeUserToJson',
            ],
        ];
    }

    public function serializeUserToJson(
        JsonSerializationVisitor $visitor,
        \Murmur_User $user,
        array $type,
        Context $context
    )
    {
        return $visitor->getNavigator()->accept(
            new UserFacade($user),
            ['name' => 'Vma\Domain\Murmur\Facade\UserFacade'],
            $context
        );
    }
}