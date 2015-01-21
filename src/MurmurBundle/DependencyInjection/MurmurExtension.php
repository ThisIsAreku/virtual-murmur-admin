<?php

namespace MurmurBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class MurmurExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        if ($container->getParameter('vma_ice_include')) {
            $separator = ':';
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $separator = ';';
            }
            set_include_path(get_include_path().$separator.$container->getParameter('vma_ice_include'));
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }


    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'murmur';
    }
}
