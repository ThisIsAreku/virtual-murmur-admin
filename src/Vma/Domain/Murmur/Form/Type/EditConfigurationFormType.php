<?php

namespace Vma\Domain\Murmur\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EditConfigurationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('configuration', 'collection', [
                'type'         => 'textarea',
                'allow_add'    => true,
                'allow_delete' => true,
            ]);
    }

    public function getName()
    {
        return 'edit_configuration';
    }
}
