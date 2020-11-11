<?php

declare(strict_types=1);

/*
 * This file is part of the "Symphony CMS: Extension Asset Management" repository.
 *
 * Copyright 2020 Alannah Kearney <hi@alannahkearney.com>
 *
 * For the full copyright and license information, please view the LICENCE
 * file that was distributed with this source code.
 */

namespace pointybeard\Symphony\Extensions\ExtensionAssetManagement\Assets;

use pointybeard\Symphony\Extensions\ExtensionAssetManagement;

class Datasource extends ExtensionAssetManagement\AbstractInstallableAsset
{
    public function getTargetPathname(): string
    {
        return $this->getExtensionDirectory().'/data-sources/data.'.strtolower($this->name()).'.php';
    }

    public function getPathname(): string
    {
        return $this->getExtensionDirectory()."/src/Includes/Datasources/datasource{$this->name()}.php";
    }

    public function getUsedBy(): ?array
    {
        return [];
    }
}
