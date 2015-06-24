<?php

namespace Vma\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $murmurMeta = $this->get('murmur.meta');
        if ($murmurMeta == null) {
            throw new \Exception();
        }

        $aliveServers = $murmurMeta->getBootedServers();

        return $this->render('WebBundle::index.html.twig', ['aliveServers' => $aliveServers]);
    }

    public function viewAction($serverId)
    {
        $murmurMeta = $this->get('murmur.meta');
        if ($murmurMeta == null) {
            throw new \Exception();
        }

        try {
            $server = $murmurMeta->getServer($serverId);
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('WebBundle::view.html.twig', ['serverId' => $serverId, 'server' => $server]);
    }


    public function loginAction()
    {
        return $this->render('WebBundle::login.html.twig');
    }
}
