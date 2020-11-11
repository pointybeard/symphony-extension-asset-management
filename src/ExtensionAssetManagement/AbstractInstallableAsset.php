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

namespace pointybeard\Symphony\Extensions\ExtensionAssetManagement;

use pointybeard\Helpers\Functions\Files;
use pointybeard\Helpers\Functions\Flags;
use pointybeard\Helpers\Functions\Paths;

abstract class AbstractInstallableAsset implements Interfaces\InstallableAssetInterface
{
    private $extensionDirectory;
    private $name;

    public const STATUS_ENABLED = 'enabled';
    public const STATUS_DISABLED = 'disabled';

    public const FLAG_NONE = 0x0000;
    public const FLAG_SKIP_CHECKS = 0x0001;
    public const FLAG_FORCE = 0x0002;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->extensionDirectory = realpath(__DIR__.'/../../../../../');
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

    public function install(int $flags = null): void
    {
        static::enable($flags);
    }

    public function uninstall(int $flags = null): void
    {
        // Check if this asset is still being used
        if (false == Flags\is_flag_set($flags, self::FLAG_SKIP_CHECKS) && null != $locations = static::getUsedBy()) {
            throw new Exceptions\AssetStillInUseException($this->name(), $locations);
        }

        static::disable();
    }

    public function enable(int $flags = null): void
    {
        if (self::STATUS_ENABLED == $this->status() && false == Flags\is_flag_set($flags, Files\FLAG_FORCE)) {
            return;
        }

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
            throw new Exceptions\EnablingAssetFailedException($this->name(), $ex->getMessage());
        }
    }

    public function disable(int $flags = null): void
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
    }
}
