<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 21/01/15
 * Time: 18:59
 */

namespace MurmurBundle\Twig;

use MurmurBundle\Proxy\MurmurIceProxyInterface;

class MurmurVersionExtension extends \Twig_Extension
{
    private $iceProxy;

    function __construct(MurmurIceProxyInterface $iceProxy)
    {
        $this->iceProxy = $iceProxy;
    }


    public function getGlobals()
    {
        return ["MurmurServerVersion" => $this->iceProxy->getVersion()];
    }


    public function getName()
    {
        return "MurmurVersionExtension";
    }
}