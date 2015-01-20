<?php

namespace Vma\Bundle\ApplicationBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Vma\Bundle\ApplicationBundle\DependencyInjection\VmaExtension;

class VmaApplicationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->registerExtension(new VmaExtension());
    }

}
