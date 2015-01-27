<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 21/01/15
 * Time: 18:59
 */

namespace AppBundle\Twig;


class AppVersionExtension extends \Twig_Extension
{
    /** @var \MurmurBundle\Model\MurmurMeta * */
    private $appVersion;

    function __construct($appVersion)
    {
        $this->appVersion = $appVersion;
    }


    public function getGlobals()
    {
        return ["AppVersion" => $this->appVersion];
    }


    public function getName()
    {
        return "AppVersionExtension";
    }

}