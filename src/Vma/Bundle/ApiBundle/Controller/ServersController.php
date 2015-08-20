<?php

namespace Vma\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServersController extends Controller
{
    /**
     * List all servers.
     *
     * @ApiDoc(
     *     resource=true,
     *     section="Servers",
     *     statusCodes={
     *         200="Returned when successful",
     *         404="Returned when page does not exist"
     *     }
     * )
     * @Rest\Get("/servers")
     */
    public function listAction()
    {
        $murmurMeta = $this->get('murmur.meta');
        if ($murmurMeta === null) {
            throw new \Exception();
        }

        return $murmurMeta->getBootedServers();
    }

    public function viewAction($serverId)
    {
        $murmurMeta = $this->get('murmur.meta');
        if ($murmurMeta === null) {
            throw new \Exception();
        }

        try {
            $server = $murmurMeta->getServer($serverId);
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('ApiBundle::view.html.twig', ['serverId' => $serverId, 'server' => $server]);
    }


    public function loginAction()
    {
        return $this->render('ApiBundle::login.html.twig');
    }
}
