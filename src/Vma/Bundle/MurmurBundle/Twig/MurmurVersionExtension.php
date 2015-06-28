<?php

/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 21/01/15
 * Time: 18:59
 */
namespace Vma\Bundle\MurmurBundle\Twig;

use Vma\Domain\Murmur\Model\MurmurMeta;

class MurmurVersionExtension extends \Twig_Extension
{
    /** @type MurmurMeta * */
    private $murmurMeta;

    function __construct(MurmurMeta $murmurMeta)
    {
        $this->murmurMeta = $murmurMeta;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('seconds_pretty', [$this, 'elapsedSecondsHumanReadableFilter']),
            new \Twig_SimpleFilter('address', [$this, 'byteArrayToStringAddress']),
            new \Twig_SimpleFilter('format_bytes', [$this, 'format_bytes']),
        ];
    }

    public function elapsedSecondsHumanReadableFilter($string)
    {
        $totalSec = intval($string);
        $hours    = intval($totalSec / 3600) % 24;
        $minutes  = intval($totalSec / 60) % 60;
        $seconds  = round($totalSec % 60, 0);
        $days     = round($totalSec / 86400);

        return ($days > 0 ? $days . "j " : '') . ($hours < 10 ? "0" . $hours : $hours) . "h " . ($minutes < 10 ? "0" . $minutes : $minutes) . "min " . ($seconds < 10 ? "0" . $seconds : $seconds) . 's';
    }

    public function byteArrayToStringAddress($byteArray)
    {
        $is_ipv4 = true;
        for ($i=0; $i < 10; $i++) { 
            $is_ipv4 &= ($byteArray[$i] == 0);
        }
        $is_ipv4 &= ($byteArray[10] == 255);
        $is_ipv4 &= ($byteArray[11] == 255);

        if ($is_ipv4) {
            return implode('.', array_slice($byteArray, 12));
        } else {
            $result = [];
            for ($i=0; $i < 16; $i+=2) {
                $sec = dechex($byteArray[$i+1]);
                if (strlen($sec) == 1) {
                    $sec = '0'.$sec;
                }
                $result[] = dechex($byteArray[$i]).$sec;
            }

            return implode(':', $result);  
        }
    }
    
    public function format_bytes($bytes, $si = true)
    {
        $unit = $si ? 1000 : 1024;
        if ($bytes <= $unit) return $bytes . " B";
        $exp = intval((log($bytes) / log($unit)));
        $pre = ($si ? "kMGTPE" : "KMGTPE");
        $pre = $pre[$exp - 1] . ($si ? "" : "i");
        return sprintf("%.1f %sB", $bytes / pow($unit, $exp), $pre);
    }

    public function getGlobals()
    {
        return ["MurmurServerVersion" => $this->murmurMeta->getVersion()];
    }


    public function getName()
    {
        return "MurmurVersionExtension";
    }

}
