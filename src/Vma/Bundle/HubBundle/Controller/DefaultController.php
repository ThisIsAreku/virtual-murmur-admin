<?php

namespace Vma\Bundle\HubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vma\Domain\Murmur\Action\ChannelMessageAction;
use Vma\Domain\Murmur\Action\EditConfigurationAction;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $murmurMeta = $this->get('murmur.meta');

        $allServers = $murmurMeta->getAllServers();

        return $this->render('HubBundle:Default:index.html.twig', ['allServers' => $allServers]);
    }

    public function confAction()
    {
        $conf = $this->get('murmur.meta')->getDefaultConf();

        return $this->render('HubBundle:Default:conf.html.twig', ['conf' => $conf]);
    }

    public function serverConfAction(Request $request, $serverId)
    {
        $murmurMeta = $this->get('murmur.meta');

        try {
            $server = $murmurMeta->getServer($serverId);
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }

        $action = new EditConfigurationAction($serverId, $server->getAllConf());
        $form   = $this->get('form.factory')->createNamed('form', 'edit_configuration', $action, ['method' => 'POST']);
        if ($form->handleRequest($request)->isValid()) {
            $this->get('vma.processor.edit_configuration')->execute($action);
            // return $this->redirectToRoute('hub.view', ['serverId' => $serverId]);
        }

        return $this->render('HubBundle:Default:edit_conf.html.twig', [
            'form'   => $form->createView(),
            'server' => $server,
        ]);
    }

    public function viewAction($serverId)
    {
        $murmurMeta = $this->get('murmur.meta');

        try {
            $server = $murmurMeta->getServer($serverId);
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('HubBundle:Default:view.html.twig', ['serverId' => $serverId, 'server' => $server]);
    }

    public function logsAction($serverId)
    {
        $murmurMeta = $this->get('murmur.meta');

        try {
            $server = $murmurMeta->getServer($serverId);
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('HubBundle:Default:logs.html.twig', ['serverId' => $serverId, 'server' => $server]);
    }

    public function messageChannelAction(Request $request, $serverId)
    {
        $murmurMeta = $this->get('murmur.meta');

        try {
            $server = $murmurMeta->getServer($serverId);
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }

        $action = new ChannelMessageAction($server);
        $form   = $this->get('form.factory')->createNamed('form', 'channel_message', $action, ['method' => 'POST']);
        if ($form->handleRequest($request)->isValid()) {
            if ($this->get('vma.processor.channel_message')->execute($action)) {
                $this->get('session')->getFlashBag()->add('success', 'Message envoyé !');
            } else {
                $this->get('session')->getFlashBag()->add('danger', 'Erreur lors de l\'envoi du message');
            }

            return $this->redirectToRoute('hub.view', ['serverId' => $serverId]);
        }

        return $this->render('HubBundle:Default:channel_message.html.twig', [
            'form'     => $form->createView(),
            'serverId' => $serverId,
            'server'   => $server
        ]);
    }
}
