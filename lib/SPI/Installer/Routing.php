<?php

namespace EzSystems\EzStudioUpgrade\SPI\Installer;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Yaml\Yaml;

abstract class Routing
{
    protected $kernel;

    protected $mainRoutingFile = 'app/config/routing.yml';

    abstract public function getRoutingFilePath();

    abstract public function getRoutingPrefix();

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    public function precondition()
    {
        $output = new ConsoleOutput();
        $output->write(sprintf(' [?] check %s file for bundle resource... ', $this->mainRoutingFile));

        $routeGroups = Yaml::parse(file_get_contents($this->mainRoutingFile));
        $resource = $this->getResourceName();

        foreach ($routeGroups as $group) {
            if (isset($group['resource']) && $group['resource'] == $resource) {
                $output->writeln('found.');
                return true;
            }
        }

        $output->writeln('not found.');
        return false;
    }

    public function install()
    {
        $output = new ConsoleOutput();
        $output->write(sprintf(' [+] add %s resource to %s file... ', $this->getResourceName(), $this->mainRoutingFile));

        $configuration = [
            '',
            '# Source: ' . $this->kernel->getBundleName() . ' installer',
            '_' . $this->kernel->getBundleName() . ':',
            '    resource: ' . $this->getResourceName(),
        ];

        if ($this->getRoutingPrefix()) {
            $configuration[] = '    prefix: ' . $this->getRoutingPrefix();
        }

        file_put_contents($this->mainRoutingFile, implode("\r", $configuration), FILE_APPEND);
        $output->writeln('done.');
    }

    protected function getResourceName()
    {
        return sprintf("@%s/%s",
            $this->kernel->getBundleName(),
            $this->getRoutingFilePath()
        );
    }
}
