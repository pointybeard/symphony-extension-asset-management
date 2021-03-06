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

namespace pointybeard\Symphony\ExtensionAssetManagement;

use pointybeard\Helpers\Functions\Files;
use pointybeard\Helpers\Functions\Flags;
use pointybeard\Helpers\Functions\Paths;
use SymphonyPDO;

abstract class AbstractInstallableAsset implements Interfaces\InstallableAssetInterface
{
    private $extensionDirectory;
    private $name;

    public function __construct(string $name, string $location = null)
    {
        $this->name = $name;
        $this->extensionDirectory = $location ?? realpath(__DIR__.'/../../../../../');
    }

    public function getUsedBy(): ?array
    {
        return [];
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): string
    {
        $class = new \ReflectionClass(static::class);

        return strtolower($class->getShortName());
    }

    public function getExtensionDirectory(): string
    {
        return $this->extensionDirectory;
    }

    public function status(): string
    {
        return is_link(static::getTargetPathname())
            ? self::STATUS_ENABLED
            : self::STATUS_DISABLED
        ;
    }

    public function runPostInstallTasks(): void
    {
        // By default, this does nothing.
        return;
    }

    public function runPostUninstallTasks(): void
    {
        // By default, this does nothing.
        return;
    }

    public function runPostEnableTasks(): void
    {
        // By default, this does nothing.
        return;
    }

    public function runPostDisableTasks(): void
    {
        // By default, this does nothing.
        return;
    }

    protected function createSymbolicLink(?int $flags = self::FLAG_NONE): void
    {
        try {
            $cwd = getcwd();

            chdir(dirname(static::getTargetPathname()));

            Files\create_symbolic_link(
                Paths\get_relative_path(dirname(static::getTargetPathname()), static::getPathname(), true),
                basename(static::getTargetPathname()),
                $flags
            );

            chdir($cwd);
        } catch (Files\Exceptions\Symlink\DestinationExistsException $ex) {
            // Not too worried if it already exists
        } catch (\Exception $ex) {
            throw new Exceptions\SymbolicLinkCreationFailedException($this->name(), $ex->getMessage());
        }
    }

    public function install(?int $flags = self::FLAG_NONE): void
    {
        static::createSymbolicLink();

        static::runPostInstallTasks();
    }

    public function getDropTablesSql(): ?string
    {
        return null;
    }

    public function uninstall(?int $flags = self::FLAG_DROP_TABLES): void
    {
        // Check if this asset is still being used
        if (false == Flags\is_flag_set($flags, self::FLAG_SKIP_CHECKS) && null != $locations = static::getUsedBy()) {
            throw new Exceptions\AssetStillInUseException($this->name(), $locations);
        }

        static::disable();

        if (true == Flags\is_flag_set($flags, self::FLAG_DROP_TABLES) && null != ($dropTableSql = static::getDropTablesSql())) {
            $query = SymphonyPDO\Loader::instance()->query($dropTableSql);
        }

        static::runPostUninstallTasks();
    }

    public function enable(?int $flags = self::FLAG_NONE): void
    {
        if (self::STATUS_ENABLED == $this->status() && false == Flags\is_flag_set($flags, Files\FLAG_FORCE)) {
            return;
        }

        static::createSymbolicLink();

        static::runPostEnableTasks();
    }

    public function disable(?int $flags = self::FLAG_NONE): void
    {
        if (self::STATUS_ENABLED != $this->status() || false == is_link(static::getTargetPathname())) {
            return;
        }

        // Check if this asset is still being used
        if (false == Flags\is_flag_set($flags, self::FLAG_SKIP_CHECKS) && null != $locations = static::getUsedBy()) {
            throw new Exceptions\AssetStillInUseException($this->name(), $locations);
        }

        if (false == unlink(static::getTargetPathname())) {
            throw new Exceptions\DisablingAssetFailedException($this->name(), 'Unable to delete symbolic link '.$this->path());
        }

        static::runPostDisableTasks();
    }
}
