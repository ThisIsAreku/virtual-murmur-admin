<?php

/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 21/01/15
 * Time: 23:17
 */
namespace Vma\Domain\Murmur\Model;

use Murmur_Server;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class MurmurServer
{

    private $murmurServer = null;
    private $murmurMeta   = null;
    private $channelCache = [];

    private function __construct(\Ice_ObjectPrx $murmurServer, MurmurMeta $meta)
    {
        $this->murmurServer = $murmurServer;
        $this->murmurMeta   = $meta;
    }

    public static function fromIceObject(\Ice_ObjectPrx $iceObject, MurmurMeta $meta)
    {
        return new self(\Murmur_ServerPrxHelper::checkedCast($iceObject), $meta);
    }

    public function getConnectedUsersByIds($ids)
    {
        if (!is_array($ids)) {
            return $this->getConnectedUsersByIds([$ids]);
        }

        $result         = [];
        $connectedUsers = $this->getUsers();
        /** @type \Murmur_User $user */
        foreach ($connectedUsers as $user) {
            if (!in_array($user->userid, $ids, true)) {
                continue;
            }

            $result[$user->userid] = $user->session;
        }

        return $result;
    }

    public function getConnectedUsersByUserNames($userNames)
    {
        if (!is_array($userNames)) {
            return $this->getConnectedUsersByIds([$userNames]);
        }

        $result         = [];
        $connectedUsers = $this->getUsers();
        /** @type \Murmur_User $user */
        foreach ($connectedUsers as $user) {
            if (!in_array($user->name, $userNames, true)) {
                continue;
            }

            $result[$user->name] = $user->session;
        }

        return $result;
    }

    public function isRunning()
    {
        return $this->murmurServer->isRunning();
    }

    public function start()
    {
        return $this->murmurServer->start();
    }

    public function stop()
    {
        return $this->murmurServer->stop();
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    /**
     * @Serializer\VirtualProperty
     */
    public function getId()
    {
        return $this->murmurServer->id();
    }

    /**
     * @Serializer\VirtualProperty
     */
    public function getName()
    {
        if (!$this->isRunning()) {
            return "Stopped server (" . $this->getId() . ")";
        }

        return $this->getRootChannel()->name;
    }

    public function getConf($key)
    {
        $confVal = $this->murmurServer->getConf($key);
        if (empty($confVal)) {
            $confVal = $this->murmurMeta->getDefaultConf($key);
        }

        return $confVal;
    }

    public function getAllConf()
    {
        return $this->murmurServer->getAllConf();
    }

    public function setConf($key, $value)
    {
        return $this->murmurServer->setConf($key, $value);
    }

    public function getUsers()
    {
        if (!$this->isRunning()) {
            return [];
        }

        return $this->murmurServer->getUsers();
    }

    /**
     * @Serializer\VirtualProperty
     */
    public function getCountUsers()
    {
        return count($this->getUsers());
    }


    /**
     * @Serializer\VirtualProperty
     */
    public function getMaxUsers()
    {
        return intval($this->getConf('users'));
    }

    public function getChannels()
    {
        return $this->murmurServer->getChannels();
    }

    public function getChannelById($id)
    {
        if (isset($this->channelCache[$id])) {
            return $this->channelCache[$id];
        }

        foreach($this->murmurServer->getChannels() as $channel) {
            if ($channel->id === $id) {
                $this->channelCache[$id] = $channel;
                return $channel;
            }
        }

        return null;
    }

    public function getRootChannel()
    {
        return $this->murmurServer->getChannels()[0];
    }

    public function getCertificateList($session)
    {
        // TODO: Implement getCertificateList() method.
    }

    public function getTree()
    {
        return new MurmurServerTree($this->murmurServer->getTree());
    }

    public function getBans()
    {
        // TODO: Implement getBans() method.
    }

    public function setBans($bans)
    {
        // TODO: Implement setBans() method.
    }

    public function kickUser($session, $reason)
    {
        // TODO: Implement kickUser() method.
    }

    public function getState($session)
    {
        // TODO: Implement getState() method.
    }

    public function setState($state)
    {
        // TODO: Implement setState() method.
    }

    public function sendMessage($session, $text)
    {
        $this->murmurServer->sendMessage($session, $text);
    }

    public function hasPermission($session, $channelid, $perm)
    {
        // TODO: Implement hasPermission() method.
    }

    public function effectivePermissions($session, $channelid)
    {
        // TODO: Implement effectivePermissions() method.
    }

    public function addContextCallback($session, $action, $text, $cb, $ctx)
    {
        // TODO: Implement addContextCallback() method.
    }

    public function removeContextCallback($cb)
    {
        // TODO: Implement removeContextCallback() method.
    }

    public function getChannelState($channelid)
    {
        // TODO: Implement getChannelState() method.
    }

    public function setChannelState($state)
    {
        // TODO: Implement setChannelState() method.
    }

    public function removeChannel($channelid)
    {
        // TODO: Implement removeChannel() method.
    }

    public function addChannel($name, $parent)
    {
        // TODO: Implement addChannel() method.
    }

    public function sendMessageChannel($channelid, $tree, $text)
    {
        $this->murmurServer->sendMessageChannel($channelid, $tree, $text);
    }

    public function getACL($channelid, $acls, $groups, $inherit)
    {
        // TODO: Implement getACL() method.
    }

    public function setACL($channelid, $acls, $groups, $inherit)
    {
        // TODO: Implement setACL() method.
    }

    public function addUserToGroup($channelid, $session, $group)
    {
        // TODO: Implement addUserToGroup() method.
    }

    public function removeUserFromGroup($channelid, $session, $group)
    {
        // TODO: Implement removeUserFromGroup() method.
    }

    public function redirectWhisperGroup($session, $source, $target)
    {
        // TODO: Implement redirectWhisperGroup() method.
    }

    public function getUserNames($ids)
    {
        return $this->murmurServer->getUserNames($ids);
    }

    public function getUserIds($names)
    {
        return $this->murmurServer->getUserIds($names);
    }

    public function registerUser($info)
    {
        // TODO: Implement registerUser() method.
    }

    public function unregisterUser($userid)
    {
        // TODO: Implement unregisterUser() method.
    }

    public function updateRegistration($userid, $info)
    {
        // TODO: Implement updateRegistration() method.
    }

    public function getRegistration($userid)
    {
        // TODO: Implement getRegistration() method.
    }

    public function getRegisteredUsers($filter)
    {
        // TODO: Implement getRegisteredUsers() method.
    }

    public function verifyPassword($name, $pw)
    {
        // TODO: Implement verifyPassword() method.
    }

    public function getTexture($userid)
    {
        // TODO: Implement getTexture() method.
    }

    public function setTexture($userid, $tex)
    {
        // TODO: Implement setTexture() method.
    }


    /**
     * @Serializer\VirtualProperty
     */
    public function getUptime()
    {
        return $this->murmurServer->getUptime();
    }

    public function getLog($first = 0, $last = 10)
    {
        return $this->murmurServer->getLog($first, $last);
    }


    /**
     * @Serializer\VirtualProperty
     */
    public function getLogLen()
    {
        return $this->murmurServer->getLogLen();
    }
}
