<?php

namespace EzSystems\EzStudioUpgrade\SPI\Installer;

use Doctrine\DBAL\Schema\DB2SchemaManager;
use Exception;
use eZ\Publish\Core\Persistence\Database\DatabaseHandler;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class Database
{
    /** @var $handler DatabaseHandler */
    protected $handler;

    /** @var $schema DB2SchemaManager */
    protected $schema;

    abstract public function getSqlFilePath();

    public function __construct(DatabaseHandler $handler)
    {
        $this->handler = $handler;
        $this->schema = $handler->getConnection()->getSchemaManager();
    }

    public function install()
    {
        $output = new ConsoleOutput();
        $output->write(sprintf(' [+] execute SQL queries from install.sql file... '));

        try {
            $this->handler->beginTransaction();
            $this->handler->exec(file_get_contents($this->getSqlFilePath()));
            $this->handler->commit();
        }
        catch(Exception $e) {
            $this->handler->rollBack();

            throw $e;
        }

        $output->writeln('done.');
    }

    protected function hasTable($name)
    {
        return in_array($name, $this->schema->listTableNames());
    }
}
