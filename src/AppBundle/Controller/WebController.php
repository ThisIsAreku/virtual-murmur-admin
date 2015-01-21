<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Web:index.html.twig');
    }
    /**
     * @Route("/view/{serverId}", name="web.view")
     */
    public function viewAction($serverId)
    {
        $murmurProxy = $this->get('murmur.proxy');

        $server = $murmurProxy->getServer($serverId);

        return $this->render('AppBundle:Web:view.html.twig', [
            'serverId'  => $serverId,
            'server'    => $server
        ]);
    }
}
