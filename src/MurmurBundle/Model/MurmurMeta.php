<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 21/01/15
 * Time: 23:26
 */

namespace MurmurBundle\Model;


use MurmurBundle\Proxy\IceProxy;

class MurmurMeta
{

    /** @var \Murmur_Meta **/
    private $murmurMeta;

    private $version;

    function __construct(IceProxy $iceProxy)
    {
        $this->murmurMeta = $iceProxy->getMeta();
    }

    /**
     * @return \Murmur_Meta
     */
    public function getMurmurMeta()
    {
        return $this->murmurMeta;
    }

    public function getVersion()
    {
        if ($this->version == null) {
            $major = $minor = $patch = $text = 0;
            $this->getMurmurMeta()->getVersion($major, $minor, $patch, $text);
            $this->version = $major . '.' . $minor . '.' . $patch . ' ' . $text;
        }

        return $this->version;
    }

    public function getDefaultConf()
    {
        return $this->getMurmurMeta()->getDefaultConf();
    }


    public function getAllServers()
    {
        return $this->getMurmurMeta()->getAllServers();
    }

    public function getBootedServers()
    {
        return $this->getMurmurMeta()->getBootedServers();
    }

    public function getServer($id)
    {
        return MurmurServer::fromIceObject($this->getMurmurMeta()->getServer((int)$id));
    }

    public function createServer()
    {
        return $this->getMurmurMeta()->newServer();
    }

    public function addCallback($cb)
    {
        // TODO: Implement addCallback() method.
    }

    public function removeCallback($cb)
    {
        // TODO: Implement removeCallback() method.
    }

    public function getUptime()
    {
        return $this->getMurmurMeta()->getUptime();
    }

    public function getSlice()
    {
        // TODO: Implement getSlice() method.
    }

    public function getSliceChecksums()
    {
        // TODO: Implement getSliceChecksums() method.
    }
}