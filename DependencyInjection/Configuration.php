<?php

namespace Fancyweb\HtmlCliDumperBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('html_cli_dumper');

        $rootNode
            ->canBeDisabled()
                ->children()
                    ->scalarNode('save_directory_path')->defaultValue('%kernel.root_dir%/../web/_html_cli_dumper_data')->cannotBeEmpty()->end()
                    ->scalarNode('view_base_url')->defaultValue('%router.request_context.scheme%://%router.request_context.host%/_html_cli_dumper_data')->cannotBeEmpty()->end()
                    ->booleanNode('disable_cli_dump')->defaultFalse()->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
