<?php

namespace Vma\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $murmurMeta = $this->get('murmur.meta');

        try {
            $aliveServers = $murmurMeta->getBootedServers();
        } catch (\Exception $e) {
            throw new InternalErrorException();
        }

        return $this->render('WebBundle::index.html.twig', ['aliveServers' => $aliveServers]);
    }

    public function viewAction($serverId)
    {
        $murmurMeta = $this->get('murmur.meta');

        try {
            $server = $murmurMeta->getServer($serverId);
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('WebBundle::view.html.twig', ['serverId' => $serverId, 'server' => $server]);
    }
}
