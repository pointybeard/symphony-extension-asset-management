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

namespace pointybeard\Symphony\ExtensionAssetManagement\Exceptions;

class AssetStillInUseException extends ExtensionAssetManagementException
{
    public function __construct(string $name, array $locations, int $code = 0, \Exception $previous = null)
    {
        parent::__construct("Unable to disable or uninstall asset '{$name}'. It is currently in use by: ".implode(', ', $locations), $code, $previous);
    }
}
