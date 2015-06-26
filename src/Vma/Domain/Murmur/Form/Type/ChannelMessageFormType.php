<?php

namespace Vma\Domain\Murmur\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ChannelMessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', 'textarea')
            ->add('async', 'checkbox', [
                'required' => false,
            ])
            ->add('recursive', 'checkbox', [
                'required' => false,
            ])
            ->addEventListener(FormEvents::POST_SET_DATA, [$this, 'onPostSetData']);;
    }

    public function onPostSetData(FormEvent $event)
    {
        $action = $event->getData();
        $form   = $event->getForm();

        if (!$action) {
            return;
        }

        $channelIds = [];
        foreach ($action->getServer()->getChannels() as $channel) {
            $channelIds[$channel->id] = $channel->name;
        }

        $form->add('channelIds', 'choice', [
            'multiple' => true,
            'expanded' => true,
            'choices'  => $channelIds
        ]);
    }

    public function getName()
    {
        return 'channel_message';
    }
}
