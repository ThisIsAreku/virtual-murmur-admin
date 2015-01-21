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


    public function getGlobals()
    {
        return ["MurmurServerVersion" => $this->murmurMeta->getVersion()];
    }


    public function getName()
    {
        return "MurmurVersionExtension";
    }
}