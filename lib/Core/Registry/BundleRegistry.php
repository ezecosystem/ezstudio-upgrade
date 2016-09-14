<?php

namespace EzSystems\EzStudioUpgrade\Core\Registry;

use EzSystems\EzStudioUpgrade\SPI\Bundle;

class BundleRegistry
{
    protected $bundles = [];

    public function addBundle($name, Bundle $bundle, $priority = 0)
    {
        $this->bundles[$priority][$name] = $bundle;
    }

    public function getBundles()
    {
        krsort($this->bundles);

        $sorted = [];

        foreach ($this->bundles as $priority => $bundles) {
            $sorted = array_merge($sorted, $bundles);
        }

        return $sorted;
    }
}
