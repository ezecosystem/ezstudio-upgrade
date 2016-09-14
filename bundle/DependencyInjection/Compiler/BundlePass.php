<?php

namespace EzSystems\EzStudioUpgradeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class BundlePass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('ezstudio_upgrade.registry.bundle')) {
            return;
        }

        $registry = $container->findDefinition('ezstudio_upgrade.registry.bundle');
        $bundles = $container->findTaggedServiceIds('ezstudio_upgrade.bundle');

        foreach ($bundles as $id => $tags) {
            foreach ($tags as $attributes) {
                isset($attributes['priority']) ?: $attributes['priority'] = 0;

                $registry->addMethodCall('addBundle', [$attributes['bundle'], new Reference($id), $attributes['priority']]);
            }
        }
    }
}
