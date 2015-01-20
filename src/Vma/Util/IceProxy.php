<?php

namespace Vma\Util;

class IceProxy 
{
    private $iceHost;
    private $iceSecret;

    function __construct($iceHost, $iceSecret)
    {
        if (!extension_loaded('ice')) {
            die('Ice is missing');
        }

        $this->iceHost = $iceHost;
        $this->iceSecret = $iceSecret;
    }

    private function loadIce()
    {
        if (!function_exists('Ice_intVersion') || Ice_intVersion() < 30400) {
            $this->loadIce33();
        } else {
            $this->loadIce34();
        }
    }

    private function loadIce34()
    {

    }

    private function loadIce33()
    {

    }


}
