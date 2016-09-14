<?php

namespace EzSystems\EzStudioUpgrade\SPI\Installer;

use RuntimeException;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;

abstract class Composer
{
    abstract public function getComposerName();

    public function precondition()
    {
        $output = new ConsoleOutput();
        $output->write(sprintf(' [?] check composer.json for "%s" dependency... ', $this->getComposerName()));

        $composerShow = new Process('composer show ' . $this->getComposerName());
        $composerShow->run();

        if ($composerShow->isSuccessful()) {
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
        $output->write(sprintf(' [+] add "%s" dependency to composer.json... ', $this->getComposerName()));

        $composerRequire = new Process('composer require --quiet ' . $this->getComposerName());
        $composerRequire->setTimeout(600);
        $composerRequire->run();

        if (!$composerRequire->isSuccessful()) {
            throw new RuntimeException($composerRequire->getErrorOutput());
        }

        $output->writeln('done.');
    }
}
