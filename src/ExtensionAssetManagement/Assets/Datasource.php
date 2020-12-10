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

class Datasource extends ExtensionAssetManagement\AbstractInstallableAsset
{
    public function getTargetPathname(): string
    {
        return $this->getExtensionDirectory().'/data-sources/data.'.strtolower($this->name()).'.php';
    }

    public function getPathname(): string
    {
        return $this->getExtensionDirectory()."/src/Includes/Datasources/{$this->name()}.php";
    }

    public function getUsedBy(): ?array
    {
        $query = SymphonyPDO\Loader::instance()->query(
            "SELECT `handle`, `data_sources` FROM tbl_pages WHERE `data_sources` LIKE '%".strtolower($this->name())."%'"
        );

        $usedBy = [];

        foreach ($query->fetchAll() as $row) {
            $d = explode(',', $row['data_sources']);
            if (in_array(strtolower($this->name()), $d)) {
                $usedBy[] = $d['handle'];
            }
        }

        return false == empty($usedBy) ? $usedBy : null;
    }
}
