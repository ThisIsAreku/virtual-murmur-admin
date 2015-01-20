<?php

namespace Vma\Bundle\ApplicationBundle\Controller;

use Vma\Util;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/hub", name="homepage")
     */
    public function indexAction()
    {
        $iceProxy = $this->get('vma.util.ice_proxy');
        return $this->render('VmaApplicationBundle:Hub:index.html.twig');
    }
}
