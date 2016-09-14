<?php

namespace EzSystems\EzStudioUpgradeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class EzSystemsEzStudioUpgradeExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array $configs An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('bundles/studio_ui.yml');
        $loader->load('bundles/flex_workflow.yml');
        $loader->load('bundles/landing_page.yml');
        $loader->load('bundles/notifications.yml');
        $loader->load('bundles/ez_studio.yml');
    }
}
