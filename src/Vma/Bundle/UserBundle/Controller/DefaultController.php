<?php

namespace Vma\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function loginAction()
    {
        return $this->render('UserBundle:Default:login.html.twig');
    }
}
