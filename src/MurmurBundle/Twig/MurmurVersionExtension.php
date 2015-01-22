<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 21/01/15
 * Time: 18:59
 */

namespace MurmurBundle\Twig;

use MurmurBundle\Model\MurmurMeta;

class MurmurVersionExtension extends \Twig_Extension
{
    /** @var \MurmurBundle\Model\MurmurMeta **/
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
        if(empty($string) || !is_numeric($string))
            return '0 secs';

        $blocks = array(
            'year' => 52*7*24*60*60,
            'month' => 30*24*60*60,
            'week' => 7*24*60*60,
            'day' => 24*60*60,
            'hour' => 60*60,
            'min' => 60,
            'sec' => 1,
        );

        $secs = intval($string);
        $output = array();

        foreach($blocks as $label => $increment) {
            $n = floor($secs/$increment);
            $secs -= ($n * $increment);

            if(!empty($n))
                $output[] = sprintf("%d %s%s",
                    $n,
                    $label,
                    ($n==1) ? '' : 's'
                );
        }

        if(!empty($length))
            $output = array_slice($output, 0, $length);

        return implode(', ', $output);
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