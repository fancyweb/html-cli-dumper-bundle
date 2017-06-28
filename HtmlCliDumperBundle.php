<?php

namespace Fancyweb\HtmlCliDumperBundle;

use Fancyweb\HtmlCliDumperBundle\DependencyInjection\Compiler\ReplaceCliDumperPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HtmlCliDumperBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ReplaceCliDumperPass());
    }
}
