<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 21/01/15
 * Time: 23:17
 */

namespace MurmurBundle\Model;

use Murmur_Server;

class MurmurServer
{

    /** @var \Murmur_Server */
    private $murmurServer = null;

    private function __construct(\Ice_ObjectPrx $murmurServer)
    {
        $this->murmurServer = $murmurServer;
    }

    /**
     * @param \Ice_ObjectPrx $iceObject
     * @return MurmurServer
     */
    public static function fromIceObject(\Ice_ObjectPrx $iceObject)
    {
        return new self(\Murmur_ServerPrxHelper::checkedCast($iceObject));
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

    public function getId()
    {
        return $this->murmurServer->id();
    }

    public function getName()
    {
        return $this->getRootChannel()->name;
    }

    public function getConf($key)
    {
        return $this->murmurServer->getConf($key);
    }

    public function getAllConf()
    {
        return $this->murmurServer->getAllConf();
    }

    public function setConf($key, $value)
    {
        return $this->murmurServer->getConf($key, $value);
    }

    public function getUsers()
    {
        return $this->murmurServer->getUsers();
    }

    public function getChannels()
    {
        return $this->murmurServer->getChannels();
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
        return $this->murmurServer->getTree();
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
        // TODO: Implement sendMessageChannel() method.
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
        // TODO: Implement getUserNames() method.
    }

    public function getUserIds($names)
    {
        // TODO: Implement getUserIds() method.
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

    public function getUptime()
    {
        return $this->murmurServer->getUptime();
    }
}