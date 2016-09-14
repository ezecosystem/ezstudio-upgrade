<?php

namespace EzSystems\EzStudioUpgradeBundle\Bundles\Notifications;

use EzSystems\EzStudioUpgrade\SPI\Installer;
use EzSystems\EzStudioUpgrade\SPI\Installer\Kernel as BaseKernel;

class Kernel extends BaseKernel implements Installer
{
    public function getBundleClass()
    {
        return 'EzSystems\NotificationBundle\EzSystemsNotificationBundle';
    }

    public function getBundleName()
    {
        return 'NotificationBundle';
    }
}
