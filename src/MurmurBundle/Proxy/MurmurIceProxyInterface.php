<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 21/01/15
 * Time: 19:05
 */

namespace MurmurBundle\Proxy;


interface MurmurIceProxyInterface {
    public function getVersion();
    public function getDefaultConf();
    public function getAllServers();
    public function getBootedServers();
    public function getServer($srvid);
    public function createServer();
}