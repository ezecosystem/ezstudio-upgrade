<?php

namespace EzSystems\EzStudioUpgradeBundle\Bundles\Notifications;

use EzSystems\EzStudioUpgrade\SPI\Installer;
use EzSystems\EzStudioUpgrade\SPI\Installer\Composer as BaseComposer;

class Composer extends BaseComposer implements Installer
{
    public function getComposerName()
    {
        return 'ezsystems/ezstudio-notifications';
    }
}
