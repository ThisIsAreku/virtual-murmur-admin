<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HubController extends Controller
{
    /**
     * @Route("/hub", name="hub")
     */
    public function indexAction()
    {

        throw new NotFoundHttpException();
        /** @var \MurmurBundle\Proxy\MurmurIceProxyInterface $murmurProxy */
        //$murmurProxy = $this->get('murmur.proxy');
/*
        $allServersUsers = [];
        $serverTree = null;
        $server = null;
        $allServers = $murmurProxy->getAllServers();
        foreach($allServers as $server) {
            $serverNames[] = $server->getChannels()[0];
            $allServersUsers = array_merge($allServersUsers, $server->getUsers());
        }

        var_dump($allServers[0]->getAllConf());
        die($allServers[0]);

        $serverTree = $allServers[0]->getTree();
*/
        return $this->render('AppBundle:Hub:index.html.twig', [
            /*'serverTree' => $serverTree,
            'allServers' => $allServers,
            'allServersUsers' => $allServersUsers*/
        ]);
    }
}
