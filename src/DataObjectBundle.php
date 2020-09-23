<?php

declare(strict_types=1);

namespace ViTech\DataObjectBundle;

use ViTech\DataObjectBundle\Resolver\RequestObjectResolver;
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
        $container->setDefinition('vi_tech.dto.object_factory', $definition);
        $container->setAlias(ObjectFactoryInterface::class, 'vi_tech.dto.object_factory');

        $definition = new Definition(RequestObjectResolver::class, [new Reference(ObjectFactoryInterface::class)]);
        $definition->addTag('controller.argument_value_resolver');
        $container->setDefinition('vi_tech.dto.resolver.request_object', $definition);
    }
}
