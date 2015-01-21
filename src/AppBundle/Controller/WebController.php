<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $murmurMeta = $this->get('murmur.meta');

        try {
            /** @var \MurmurBundle\Model\MurmurServer $server */
            $server = $murmurMeta->getServer($serverId);
        } catch(\Exception $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('AppBundle:Web:view.html.twig', [
            'serverId'  => $serverId,
            'server'    => $server
        ]);
    }
}
