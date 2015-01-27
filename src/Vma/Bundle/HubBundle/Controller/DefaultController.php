<?php

namespace Vma\Bundle\HubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HubBundle:Default:index.html.twig', array('name' => 'r'));
    }
}
