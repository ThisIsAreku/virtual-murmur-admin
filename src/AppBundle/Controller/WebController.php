<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class WebController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        /** @var \MurmurBundle\Model\MurmurMeta $murmurMeta */
        $murmurMeta = $this->get('murmur.meta');

        try {
            /** @var array $aliveServers */
            $aliveServers = $murmurMeta->getBootedServers();
        } catch (\Exception $e) {
            throw new InternalErrorException();
        }
        return $this->render('AppBundle:Web:index.html.twig', [
            'aliveServers' => $aliveServers
        ]);
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
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('AppBundle:Web:view.html.twig', [
            'serverId' => $serverId,
            'server' => $server
        ]);
    }
}
