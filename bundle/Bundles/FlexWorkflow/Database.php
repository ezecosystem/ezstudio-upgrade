<?php

namespace EzSystems\EzStudioUpgradeBundle\Bundles\FlexWorkflow;

use Exception;
use EzSystems\EzStudioUpgrade\SPI\Installer;
use EzSystems\EzStudioUpgrade\SPI\Installer\Database as BaseDatabase;
use Symfony\Component\Console\Output\ConsoleOutput;

class Database extends BaseDatabase implements Installer
{
    public function precondition()
    {
        $output = new ConsoleOutput();
        $output->write(sprintf(' [?] check database for required tables... '));

        $hasTables = $this->hasTable('ezflexworkflow') && $this->hasTable('ezflexworkflow_message');

        if ($hasTables) {
            $output->writeln('found.');
            return true;
        }
        else {
            $output->writeln('not found.');
            return false;
        }
    }

    public function getSqlFilePath()
    {
        return __DIR__ . '/install.sql';
    }
}
