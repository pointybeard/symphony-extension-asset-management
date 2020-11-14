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

class Event extends ExtensionAssetManagement\AbstractInstallableAsset
{
    public function getTargetPathname(): string
    {
        return $this->getExtensionDirectory().'/events/event.'.strtolower($this->name()).'.php';
    }

    public function getPathname(): string
    {
        return $this->getExtensionDirectory()."/src/Includes/Events/event{$this->name()}.php";
    }

    public function getUsedBy(): ?array
    {
        $query = SymphonyPDO\Loader::instance()->query(
            "SELECT `handle`, `events` FROM tbl_pages WHERE `events` LIKE '%".strtolower($this->name())."%'"
        );

        $usedBy = [];

        foreach ($query->fetchAll() as $row) {
            $e = explode(',', $row['events']);
            if (in_array(strtolower($this->name()), $e)) {
                $usedBy[] = $e['handle'];
            }
        }

        return false == empty($usedBy) ? $usedBy : null;
    }
}
