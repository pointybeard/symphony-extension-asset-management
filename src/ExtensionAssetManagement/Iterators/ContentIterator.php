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

namespace pointybeard\Symphony\ExtensionAssetManagement\Iterators;

use pointybeard\Symphony\ExtensionAssetManagement;

class ContentIterator extends ExtensionAssetManagement\AbstractAssetIterator
{
    public function current(): ExtensionAssetManagement\AbstractInstallableAsset
    {
        $file = (object) parent::current();

        return ExtensionAssetManagement\AssetFactory::build('Content', $file->name);
    }
}
