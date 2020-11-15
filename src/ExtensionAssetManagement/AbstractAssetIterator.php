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

use pointybeard\Helpers\Foundation\Factory;

abstract class AbstractAssetIterator extends \RegexIterator
{
    protected $path = null;
    protected $pattern = null;
    protected $extension = null;

    public function __construct(string $path, string $pattern = "@(?<name>[A-z_-]+)\.php$@i")
    {
        $this->path = $path;
        $this->pattern = $pattern;
        $this->extension = null;
        $this->extensionDirectory = null;

        // Since this is a composer library, we cannot rely on being in
        // the vendor folder of the calling extension. So, instead, lets
        // use the $path to deduce where we are
        preg_match("@extensions/([^/]+)@i", $this->path, $match);

        [,$this->extension] = $match;

        if($this->extension !== null) {
            $this->extensionDirectory = EXTENSIONS . "/{$this->extension}";
        }

        // Create the AssetFactory class if it doesn't already exist
        if (false == class_exists(__NAMESPACE__.'\\AssetFactory')) {
            Factory\create(
                __NAMESPACE__.'\\AssetFactory',
                __NAMESPACE__.'\\Assets\\%s',
                __NAMESPACE__.'\\AbstractInstallableAsset'
            );
        }

        $it = new \ArrayIterator();

        foreach (new \DirectoryIterator($this->path) as $item) {
            if (true == $item->isDot() || true == $item->isDir()) {
                continue;
            }
            $it->append($item->getPathname());
        }

        parent::__construct(
            $it,
            $this->pattern,
            \RegexIterator::GET_MATCH
        );
    }

    /**
     * Passes each record into $callback.
     *
     * @return int Returns total number of items iterated over
     */
    public function each(callable $callback, array $args = []): int
    {
        $count = 0;

        // Ensure we're at the start of the iterator
        $this->rewind();

        // Loop over every item in the iterator
        while ($this->valid()) {
            // Execute the callback, giving it the data and any argments passed in
            $callback($this->current(), $args);
            // Move the cursor
            $this->next();
            // Keep track of the number of items we've looped over
            ++$count;
        }

        // Go back to the start
        $this->rewind();

        return $count;
    }
}
