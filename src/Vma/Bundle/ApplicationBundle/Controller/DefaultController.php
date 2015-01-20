<?php

namespace Vma\Bundle\ApplicationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/hub", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('VmaApplicationBundle:Hub:index.html.twig');
    }
}
