<?php

namespace Vma\Bundle\MurmurBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MurmurExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');


        if ($container->getParameter('vma_ice_include')) {
            $separator = ':';
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $separator = ';';
            }
            set_include_path(get_include_path() . $separator . $container->getParameter('vma_ice_include'));
        }
    }
}
