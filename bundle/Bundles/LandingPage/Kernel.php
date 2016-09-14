<?php

namespace EzSystems\EzStudioUpgradeBundle\Bundles\LandingPage;

use EzSystems\EzStudioUpgrade\SPI\Installer;
use EzSystems\EzStudioUpgrade\SPI\Installer\Kernel as BaseKernel;

class Kernel extends BaseKernel implements Installer
{
    public function getBundleClass()
    {
        return 'EzSystems\LandingPageFieldTypeBundle\EzSystemsLandingPageFieldTypeBundle';
    }

    public function getBundleName()
    {
        return 'EzSystemsLandingPageFieldTypeBundle';
    }
}
