<?php

namespace Vma\Util;

class IceProxy 
{
    private $iceHost;
    private $iceSecret;
    private $meta;

    function __construct($iceHost, $iceSecret, $sliceIncludeFile, $iceIncludePath = null)
    {
        if (!extension_loaded('ice')) {
            die('Ice is missing');
        }

        if (!empty($iceIncludePath)) {
            $separator = ':';
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $separator = ';';
            }
            set_include_path(get_include_path().$separator.$iceIncludePath);
        }

        if (!file_exists($sliceIncludeFile)) {
            die('Slice file is missing');
        }

        require_once 'Ice.php';
        require_once $sliceIncludeFile;

        $this->iceHost = $iceHost;
        $this->iceSecret = $iceSecret;

        $this->loadIce();
    }

    private function loadIce()
    {
        if (!function_exists('Ice_intVersion') || Ice_intVersion() < 30400) {
            $this->loadIce33();
        } else {
            $this->loadIce34();
        }

        echo 'end';

        die;
    }

    private function loadIce33()
    {
        echo __METHOD__;
        global $ICE;
        Ice_loadProfile();

        try {
            $conn = $ICE->stringToProxy($this->iceHost);
            $this->meta = $conn->ice_checkedCast('::Murmur::Meta');
            var_dump($this->meta);
        } catch (\Ice_ProxyParseException $e) {
            echo $e->getMessage();
        }
    }

    private function loadIce34()
    {
        $initData = new \Ice_InitializationData();
        $initData->properties = Ice_createProperties();
        $initData->properties->setProperty('Ice.ImplicitContext', 'Shared');
        $ICE = Ice_initialize($initData);

        try {
            $this->meta = \Murmur_MetaPrxHelper::checkedCast($ICE->stringToProxy($this->iceHost));
            var_dump($this->meta);
            $this->meta = $this->meta->ice_context(['secret' => $this->iceSecret]);
        } catch (\Ice_ConnectionRefusedException $e) {
            echo "Cannot connect to backend";
        }
    }


}
