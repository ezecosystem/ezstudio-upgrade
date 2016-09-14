<?php

namespace EzSystems\EzStudioUpgrade\SPI;

interface Installer
{
    public function precondition();

    public function install();
}
