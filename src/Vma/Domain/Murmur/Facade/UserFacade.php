<?php

namespace Vma\Domain\Murmur\Facade;

use JMS\Serializer\Annotation as Serializer;

class UserFacade
{
    /**
     * @Serializer\Type("integer")
     */
    public $session;
    /**
     * @Serializer\Type("integer")
     */
    public $userid;

    /**
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @Serializer\Type("integer")
     */
    public $onlinesecs;

    /**
     * @Serializer\Type("integer")
     */
    public $channel;

    /**
     * @Serializer\Type("boolean")
     */
    public $mute;

    /**
     * @Serializer\Type("boolean")
     */
    public $deaf;

    /**
     * @Serializer\Type("boolean")
     */
    public $supress;

    /**
     * @Serializer\Type("boolean")
     */
    public $selfMute;

    /**
     * @Serializer\Type("boolean")
     */
    public $selfDeaf;

    public function __construct(\Murmur_User $user)
    {
        $this->session    = $user->session;
        $this->userid     = $user->userid;
        $this->name       = $user->name;
        $this->onlinesecs = $user->onlinesecs;
        $this->channel    = $user->channel;
        $this->mute       = $user->mute;
        $this->deaf       = $user->deaf;
        $this->supress    = $user->suppress;
        $this->selfMute   = $user->selfMute;
        $this->selfDeaf   = $user->selfDeaf;
    }
}
