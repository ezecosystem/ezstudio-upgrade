<?php

namespace EzSystems\EzStudioUpgradeBundle\Bundles\StudioUI;

use EzSystems\EzStudioUpgrade\SPI\Installer;
use EzSystems\EzStudioUpgrade\SPI\Installer\Routing as BaseRouting;

class Routing extends BaseRouting implements Installer
{
    public function getRoutingFilePath()
    {
        return 'Resources/config/routing.yml';
    }

    public function getRoutingPrefix()
    {
        return false;
    }
}
