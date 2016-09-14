<?php

namespace EzSystems\EzStudioUpgradeBundle\Bundles\EzStudio;

use EzSystems\EzStudioUpgrade\SPI\Installer;
use RuntimeException;
use Sensio\Bundle\GeneratorBundle\Command\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Process\Process;

class Credentials implements Installer
{
    public function precondition()
    {
        $output = new ConsoleOutput();
        $output->write(sprintf(' [?] check composers auth.json for repository credentials... '));

        $configCredentials = new Process('composer config http-basic.updates.ez.no');
        $configCredentials->run();

        if ($configCredentials->isSuccessful()) {
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
        $input = new StringInput('');
        $helper = new QuestionHelper();

        $output->writeln(sprintf(' [+] set updates.ez.no credentials... '));
        $username = trim($helper->ask($input, $output, new Question('     Username: ')));
        $password = trim($helper->ask($input, $output, new Question('     Password: ')));

        if (empty($username)) {
            throw new RuntimeException('Username cannot be empty.');
        }

        if (empty($password)) {
            throw new RuntimeException('Password cannot be empty.');
        }

        $configCredentials = new Process(sprintf('composer config http-basic.updates.ez.no %s %s', $username, $password));
        $configCredentials->run();

        if (!$configCredentials->isSuccessful()) {
            throw new RuntimeException($configCredentials->getErrorOutput());
        }
    }
}
