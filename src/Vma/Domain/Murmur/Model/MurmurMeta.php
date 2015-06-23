<?php

/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 21/01/15
 * Time: 23:26
 */
namespace Vma\Domain\Murmur\Model;

use Vma\Domain\Murmur\Proxy\MurmurIceProxy;

class MurmurMeta
{

    /**
     * @type \Murmur_Meta
     */
    private $murmurMeta;

    private $version;

    private $defaultConfCache;

    private $proxy;

    function __construct(MurmurIceProxy $iceProxy)
    {
        if ($iceProxy->isReady()) {
            $this->proxy            = $iceProxy;
            $this->murmurMeta       = $iceProxy->getMeta();
            $this->defaultConfCache = $this->getMurmurMeta()->getDefaultConf();
        }
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
        if ($this->version === null) {
            $major = $minor = $patch = $text = 0;
            $this->getMurmurMeta()->getVersion($major, $minor, $patch, $text);
            $this->version = $major . '.' . $minor . '.' . $patch . ' (' . $text . ')';
        }

        return $this->version;
    }

    public function getDefaultConf($key = '')
    {
        if (empty($key)) {
            return $this->defaultConfCache;
        }

        if (!isset($this->defaultConfCache[$key])) {
            return null;
        }

        return $this->defaultConfCache[$key];
    }


    public function getAllServers()
    {
        $returnServers = [];
        $allServers    = $this->getMurmurMeta()->getAllServers();
        foreach ($allServers as $key => $server) {
            $server              = $this->proxy->applyIceSecret($server);
            $returnServers[$key] = MurmurServer::fromIceObject($server, $this);
        }

        return $returnServers;
    }

    public function getBootedServers()
    {
        $returnServers = [];
        $bootedServers = $this->getMurmurMeta()->getBootedServers();
        foreach ($bootedServers as $key => $server) {
            $server              = $this->proxy->applyIceSecret($server);
            $returnServers[$key] = MurmurServer::fromIceObject($server, $this);
        }

        return $returnServers;
    }

    public function getServer($id)
    {
        $server = $this->getMurmurMeta()->getServer((int)$id);
        $server = $this->proxy->applyIceSecret($server);

        return MurmurServer::fromIceObject($server, $this);
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
