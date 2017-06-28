<?php

namespace Fancyweb\HtmlCliDumperBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

class HtmlCliDumperExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        if (!in_array('Symfony\Bundle\DebugBundle\DebugBundle', $container->getParameter('kernel.bundles'))) {
            return;
        }

        $configuration = new Configuration();
        $config = $container->getParameterBag()->resolveValue($this->processConfiguration($configuration, $configs));

        if (!$config['enabled']) {
            return;
        }

        $container->setDefinition('fancyweb.html_cli_dumper.dumper', new Definition('Fancyweb\HtmlCliDumperBundle\Dumper\HtmlCliDumper', array(
            $config['save_directory_path'],
            $config['view_base_url'],
            $config['disable_cli_dump']
        )));
    }
}
