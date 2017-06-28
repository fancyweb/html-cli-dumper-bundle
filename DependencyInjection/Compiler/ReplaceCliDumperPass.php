<?php

namespace Fancyweb\HtmlCliDumperBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ReplaceCliDumperPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('fancyweb.html_cli_dumper.dumper')) {
            return;
        }

        $container->removeDefinition('var_dumper.cli_dumper');
        $container->setAlias('var_dumper.cli_dumper', 'fancyweb.html_cli_dumper.dumper');
    }
}
