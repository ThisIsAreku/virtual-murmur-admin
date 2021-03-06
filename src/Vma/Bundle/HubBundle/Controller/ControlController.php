<?php

/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 06/02/15
 * Time: 18:35
 */
namespace Vma\Bundle\HubBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vma\Domain\Murmur\Model\MurmurServer;

class ControlController extends Controller
{
    public function startstopAction($serverId)
    {
        $murmurMeta = $this->get('murmur.meta');

        $server = $murmurMeta->getServer($serverId);
        if ($server->isRunning()) {
            $server->stop();
        } else {
            $server->start();
        }

        return $this->redirect($this->generateUrl('hub.view', ['serverId' => $serverId]));
    }

}
