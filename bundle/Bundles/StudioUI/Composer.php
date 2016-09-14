<?php

namespace EzSystems\EzStudioUpgradeBundle\Bundles\StudioUI;

use EzSystems\EzStudioUpgrade\SPI\Installer;
use EzSystems\EzStudioUpgrade\SPI\Installer\Composer as BaseComposer;

class Composer extends BaseComposer implements Installer
{
    public function getComposerName()
    {
        return 'ezsystems/studio-ui-bundle';
    }
}
