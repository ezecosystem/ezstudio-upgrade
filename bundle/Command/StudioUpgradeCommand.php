<?php

namespace EzSystems\EzStudioUpgradeBundle\Command;

use EzSystems\EzStudioUpgrade\SPI\Bundle;
use EzSystems\EzStudioUpgrade\SPI\Installer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StudioUpgradeCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ezstudio:upgrade')
            ->setDescription('eZ Studio upgrade for those who migrate from eZ Platform');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $registry = $container->get('ezstudio_upgrade.registry.bundle');
        $bundles = $registry->getBundles();

        /** @var Bundle $bundle */
        foreach ($bundles as $name => $bundle) {
            $output->writeln(sprintf('<info>%s</info>', $name));

            $installers = $bundle->getInstallers();

            /** @var Installer $installer */
            foreach ($installers as $installer) {
                if (!$installer->precondition()) {
                    $installer->install();
                }
            }
        }

        $output->writeln('');
        $output->writeln('<info>Done.</info>');
    }
}
