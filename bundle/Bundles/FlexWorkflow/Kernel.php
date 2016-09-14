<?php

namespace EzSystems\EzStudioUpgradeBundle\Bundles\FlexWorkflow;

use EzSystems\EzStudioUpgrade\SPI\Installer;
use EzSystems\EzStudioUpgrade\SPI\Installer\Kernel as BaseKernel;

class Kernel extends BaseKernel implements Installer
{
    public function getBundleClass()
    {
        return 'EzSystems\FlexWorkflowBundle\EzSystemsFlexWorkflowBundle';
    }

    public function getBundleName()
    {
        return 'FlexWorkflowBundle';
    }
}
