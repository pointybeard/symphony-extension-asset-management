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

use pointybeard\Helpers\Foundation\Factory;

abstract class AbstractAssetIterator extends \RegexIterator
{
    protected $path = null;
    protected $pattern = null;

    public function __construct(string $path, string $pattern)
    {
        $this->path = $path;
        $this->pattern = $pattern;

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

    public function current(): AbstractInstallableAsset
    {
        $file = (object) parent::current();

        return AssetFactory::build(ucfirst($file->type), $file->name);
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
