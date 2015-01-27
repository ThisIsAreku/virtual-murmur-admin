<?php

namespace Vma\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
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

        return $this->render(
            'WebBundle::index.html.twig',
            [
                'aliveServers' => $aliveServers
            ]
        );
    }

    public function viewAction($serverId)
    {
        $murmurMeta = $this->get('murmur.meta');

        try {
            /** @var \MurmurBundle\Model\MurmurServer $server */
            $server = $murmurMeta->getServer($serverId);
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }

        return $this->render(
            'WebBundle::view.html.twig',
            [
                'serverId' => $serverId,
                'server'   => $server
            ]
        );
    }
}
