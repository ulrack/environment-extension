<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

use Ulrack\EnvironmentExtension\Common\UlrackEnvironmentExtensionPackage;
use GrizzIt\Configuration\Component\Configuration\PackageLocator;

PackageLocator::registerLocation(
    __DIR__,
    UlrackEnvironmentExtensionPackage::PACKAGE_NAME
);
