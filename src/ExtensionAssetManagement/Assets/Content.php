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

namespace pointybeard\Symphony\ExtensionAssetManagement\Assets;

use pointybeard\Symphony\ExtensionAssetManagement;

class Content extends ExtensionAssetManagement\AbstractInstallableAsset
{
    public function getTargetPathname(): string
    {
        return $this->getExtensionDirectory().'/content/content.'.strtolower($this->name()).'.php';
    }

    public function getPathname(): string
    {
        return $this->getExtensionDirectory()."/src/Includes/Content/{$this->name()}.php";
    }
}
