<?php

namespace EzSystems\EzStudioUpgrade\Core;

use RuntimeException;
use Sensio\Bundle\GeneratorBundle\Manipulator\KernelManipulator;

class Manipulator extends KernelManipulator
{
    public function findBundle($source, $bundleClass)
    {
        $method = $this->reflected->getMethod('registerBundles');

        $lines = array_slice($source, $method->getStartLine() - 1, $method->getEndLine() - $method->getStartLine() + 1);

        foreach ($lines as $i => $line) {
            if (trim($line) === sprintf("new %s(),", $bundleClass)) {
                return $method->getStartLine() - 1 + $i;
            }
        }

        throw new RuntimeException(sprintf('Bundle "%s" does not exist in "AppKernel::registerBundles()".', $bundleClass));
    }

    public function addBundleBefore($before, $bundle)
    {
        $bundles = $this->kernel->getBundles();

        if (!isset($bundles[$before])) {
            throw new RuntimeException(sprintf('Bundle "%s" does not exist in "AppKernel::registerBundles()".', $before));
        }

        if (!$this->reflected->getFilename()) {
            throw new RuntimeException(sprintf('Cannot add Bundle "%s" to "AppKernel::registerBundles()".', $bundle));
        }

        $source = file($this->reflected->getFilename());

        $beforeBundleClass = get_class($bundles[$before]);
        $beforeLine = $this->findBundle($source, $beforeBundleClass);

        $lines = array_merge(
            array_slice($source, 0, $beforeLine),
            [
                sprintf("            new %s(),\n", $bundle)
            ],
            array_slice($source, $beforeLine)
        );

        file_put_contents($this->reflected->getFilename(), implode('', $lines));

        return true;
    }
}