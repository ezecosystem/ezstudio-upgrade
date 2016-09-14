<?php

namespace EzSystems\EzStudioUpgradeBundle\Bundles\EzStudio;

use EzSystems\EzStudioUpgrade\SPI\Installer;
use RuntimeException;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;

class Repository implements Installer
{
    protected $repository = 'https://updates.ez.no/ttl';

    public function precondition()
    {
        $output = new ConsoleOutput();
        $output->write(sprintf(' [?] check composer.json for repository address... '));

        $configRepositories = new Process('composer config repositories');
        $configRepositories->run();

        $repositories = (array)json_decode($configRepositories->getOutput());

        foreach ($repositories as $repository) {
            if ($repository->url == $this->repository) {
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
        $output->write(sprintf(' [+] add "%s" repository to composer.json... ', $this->repository));

        $configRepository = new Process('composer config repositories.ezstudio_ttl composer '  . $this->repository);
        $configRepository->run();

        if (!$configRepository->isSuccessful()) {
            throw new RuntimeException($configRepository->getErrorOutput());
        }

        $output->writeln('done.');
    }
}
