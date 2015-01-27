<?php

namespace Vma\Domain\Murmur\Proxy;

class MurmurIceProxy
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
            die('Slice file is missing: '.$sliceIncludeFile);
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

        if (!empty($this->iceSecret)) {
            $this->meta = $this->meta->ice_context(['secret' => $this->iceSecret]);
        }
    }

    private function loadIce33()
    {
        global $ICE;
        Ice_loadProfile();

        try {
            $conn = $ICE->stringToProxy($this->iceHost);
            $this->meta = $conn->ice_checkedCast('::Murmur::Meta');
        } catch (\Ice_ProxyParseException $e) {
            echo $e->getMessage();
        }
    }

    private function loadIce34()
    {
        $initData = new \Ice_InitializationData();
        $initData->properties = Ice_createProperties();
        $initData->properties->setProperty('Ice.ImplicitContext', 'Shared');
        $initData->properties->setProperty('Ice.Default.EncodingVersion', '1.0');
        $ICE = Ice_initialize($initData);

        $proxy = $ICE->stringToProxy($this->iceHost);
        $this->meta = \Murmur_MetaPrxHelper::checkedCast($proxy);
    }

    public function getMeta()
    {
        return $this->meta;
    }


}