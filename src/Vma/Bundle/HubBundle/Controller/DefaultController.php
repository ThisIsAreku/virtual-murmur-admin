<?php

namespace Vma\Bundle\HubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $murmurMeta = $this->get('murmur.meta');

        try {
            $allServers = $murmurMeta->getAllServers();
        } catch (\Exception $e) {
            throw new InternalErrorException();
        }

        return $this->render('HubBundle:Default:index.html.twig', ['allServers' => $allServers]);
    }

    public function editAction($serverId)
    {
        $murmurMeta = $this->get('murmur.meta');

        try {
            $server = $murmurMeta->getServer($serverId);
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('HubBundle:Default:edit.html.twig', ['serverId' => $serverId, 'server' => $server]);
    }

    public function confAction()
    {
        $conf = $this->get('murmur.meta')->getDefaultConf();

        return $this->render('HubBundle:Default:conf.html.twig', ['conf' => $conf]);
    }
}
