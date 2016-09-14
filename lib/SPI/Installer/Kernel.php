<?php

namespace EzSystems\EzStudioUpgrade\SPI\Installer;

use EzSystems\EzStudioUpgrade\Core\Manipulator;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class Kernel
{
    protected $kernel;

    abstract public function getBundleClass();

    abstract public function getBundleName();

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function precondition()
    {
        $output = new ConsoleOutput();
        $output->write(sprintf(' [?] check app/AppKernel.php for "%s" bundle... ', $this->getBundleName()));

        $bundles = array_keys($this->kernel->getBundles());

        if (in_array($this->getBundleName(), $bundles)) {
            $output->writeln('found.');
            return true;
        }
        else {
            $output->writeln('not found.');
            return false;
        }
    }

    public function install()
    {
        $output = new ConsoleOutput();
        $output->write(sprintf(' [+] register "%s" bundle in app/AppKernel.php... ', $this->getBundleName()));

        $manipulator = new Manipulator($this->kernel);
        $manipulator->addBundle($this->getBundleClass());

        $output->writeln('done.');
    }
}
