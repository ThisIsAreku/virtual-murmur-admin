<?php

namespace Vma\Bundle\ApplicationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Finder\Finder;

class VmaExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = array();
        foreach ($configs as $subConfig) {
            $config = array_merge($config, $subConfig);
        }

        foreach ($config as $config_name => $config_value) {
            $container->set($this->getAlias().'.'.$config_name, $config_value);
        }

        if (!empty($config['ice_include'])) {
            $separator = ':';
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $separator = ';';
            }
            set_include_path(get_include_path().$separator.$config['ice_include']);
        }

        // Load all services definitions
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        /*$finder = new Finder();
        $finder->files()->name('*.xml')->in(__DIR__.'/../Resources/config/services');
        foreach ($finder as $file) {
            $loader->load('services/'.$file->getFilename());
        }*/
    }


    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'vma';
    }
}
