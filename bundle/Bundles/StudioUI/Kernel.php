<?php

namespace EzSystems\EzStudioUpgradeBundle\Bundles\StudioUI;

use EzSystems\EzStudioUpgrade\Core\Manipulator;
use EzSystems\EzStudioUpgrade\SPI\Installer;
use EzSystems\EzStudioUpgrade\SPI\Installer\Kernel as BaseKernel;
use Symfony\Component\Console\Output\ConsoleOutput;

class Kernel extends BaseKernel implements Installer
{
    public function getBundleClass()
    {
        return 'EzSystems\StudioUIBundle\EzSystemsStudioUIBundle';
    }

    public function getBundleName()
    {
        return 'eZStudioUIBundle';
    }

    public function install()
    {
        $output = new ConsoleOutput();
        $output->write(sprintf(' [+] register "%s" bundle in app/AppKernel.php... ', $this->getBundleName()));

        $manipulator = new Manipulator($this->kernel);
        $manipulator->addBundleBefore('eZPlatformUIBundle', $this->getBundleClass());

        $output->writeln('done.');
    }
}
