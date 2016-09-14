<?php

namespace EzSystems\EzStudioUpgrade\Core;

use EzSystems\EzStudioUpgrade\SPI\Bundle;
use EzSystems\EzStudioUpgrade\SPI\Installer;

class BaseBundle implements Bundle
{
    protected $installers = [];

    public function addInstaller(Installer $installer)
    {
        $this->installers[] = $installer;
    }

    public function getInstallers()
    {
        return $this->installers;
    }
}
