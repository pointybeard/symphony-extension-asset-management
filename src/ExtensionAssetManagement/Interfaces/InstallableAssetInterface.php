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

namespace pointybeard\Symphony\ExtensionAssetManagement\Interfaces;

interface InstallableAssetInterface
{
    public function status(): string;

    public function install(?int $flags = self::FLAG_NONE): void;

    public function uninstall(int $flags = self::FLAG_DROP_TABLES): void;

    public function enable(?int $flags = self::FLAG_NONE): void;

    public function disable(?int $flags = self::FLAG_NONE): void;

    public function getPathname(): string;

    public function getTargetPathname(): string;

    public function getUsedBy(): ?array;

    public function getDropTablesSql(): ?string;

    public function name(): string;

    public function runPostInstallTasks(): void;

    public function runPostUninstallTasks(): void;

    public function runPostEnableTasks(): void;

    public function runPostDisableTasks(): void;
}
