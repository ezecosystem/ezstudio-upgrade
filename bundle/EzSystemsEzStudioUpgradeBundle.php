<?php

namespace EzSystems\EzStudioUpgradeBundle;

use EzSystems\EzStudioUpgradeBundle\DependencyInjection\Compiler\BundlePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EzSystemsEzStudioUpgradeBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new BundlePass());
    }
}
