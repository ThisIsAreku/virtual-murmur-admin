<?php

namespace Vma\Domain\Murmur\Proxy;

class MurmurIceProxy
{
    private $iceHost;
    private $iceSecret;

    /**
     * @var \Murmur_Meta $meta
     */
    private $meta = null;

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
            set_include_path(get_include_path() . $separator . $iceIncludePath);
        }

        if (!file_exists($sliceIncludeFile)) {
            die('Slice file is missing: ' . $sliceIncludeFile);
        }

        require_once 'Ice.php';
        require_once $sliceIncludeFile;

        $this->iceHost = $iceHost;
        $this->iceSecret = $iceSecret;

        try {
            $this->loadIce();
        } catch (\Ice_ConnectionRefusedException $e) {
            echo 'Connection failed';
        }
    }

    private function loadIce()
    {
        if (class_exists("Ice_InitializationData")) {
            $this->loadIce34();
        } else
        if (!function_exists('Ice_intVersion') || Ice_intVersion() < 30400) {
            $this->loadIce33();
        }

        $this->meta = $this->applyIceSecret($this->meta);
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

    public function isReady()
    {
        return $this->getMeta() !== null;
    }

    public function applyIceSecret($meta)
    {
        if (!empty($this->iceSecret)) {
            return $meta->ice_context(['secret' => $this->iceSecret]);
        }

        return $meta;
    }


}
