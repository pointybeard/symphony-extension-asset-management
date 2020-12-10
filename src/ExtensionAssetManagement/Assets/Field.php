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
use SymphonyPDO;

class Field extends ExtensionAssetManagement\AbstractInstallableAsset
{
    public function getTargetPathname(): string
    {
        return $this->getExtensionDirectory().'/fields/field.'.strtolower($this->name()).'.php';
    }

    public function getPathname(): string
    {
        return $this->getExtensionDirectory()."/src/Includes/Fields/{$this->name()}.php";
    }

    public function getUsedBy(): ?array
    {
        $query = SymphonyPDO\Loader::instance()->query(
            "SELECT DISTINCT s.name FROM `tbl_fields` as `f` LEFT JOIN `tbl_sections` as `s` ON f.parent_section = s.id WHERE f.type = '".strtolower($this->name())."' ORDER BY s.name ASC;"
        );

        $sections = $query->fetchAll(\PDO::FETCH_COLUMN, 0);

        return false != $sections ? $sections : null;
    }

    public function getDropTablesSql(): ?string
    {
        return 'DROP TABLE IF EXISTS `tbl_fields_'.strtolower($this->name()).'`;';
    }
}
