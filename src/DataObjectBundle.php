<?php

declare(strict_types=1);

namespace Vseinstrumentiru\DataObjectBundle;

use Vseinstrumentiru\DataObjectBundle\Resolver\RequestObjectResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DataObjectBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $definition = new Definition(ObjectFactory::class);
        $container->setDefinition('vseinstrumentiru.dto.object_factory', $definition);
        $container->setAlias(ObjectFactoryInterface::class, 'vseinstrumentiru.dto.object_factory');

        $definition = new Definition(RequestObjectResolver::class, [new Reference(ObjectFactoryInterface::class)]);
        $definition->addTag('controller.argument_value_resolver');
        $container->setDefinition('vseinstrumentiru.dto.resolver.request_object', $definition);
    }
}
