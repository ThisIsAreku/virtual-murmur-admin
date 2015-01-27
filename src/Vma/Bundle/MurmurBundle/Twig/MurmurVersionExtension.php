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
    /** @var MurmurMeta * */
    private $murmurMeta;

    function __construct(MurmurMeta $murmurMeta)
    {
        $this->murmurMeta = $murmurMeta;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('seconds_pretty', array($this, 'elapsedSecondsHumanReadableFilter')),
        );
    }

    public function elapsedSecondsHumanReadableFilter($string)
    {
        $totalSec = intval($string);
        $hours = intval($totalSec / 3600) % 24;
        $minutes = intval($totalSec / 60) % 60;
        $seconds = round($totalSec % 60, 0);

        return ($hours < 10 ? "0" . $hours : $hours) . "h " . ($minutes < 10 ? "0" . $minutes : $minutes) . "min " . ($seconds < 10 ? "0" . $seconds : $seconds) . 's';
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