<?php

namespace EzSystems\EzStudioUpgrade\SPI;

interface Bundle
{
    public function addInstaller(Installer $installer);

    public function getInstallers();
}
