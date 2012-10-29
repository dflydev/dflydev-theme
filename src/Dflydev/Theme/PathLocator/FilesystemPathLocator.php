<?php

/*
 * This file is a part of dflydev/theme.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Theme\PathLocator;

use Dflydev\Theme\PathMapper\PathMapperInterface;

/**
 * Filesystem Path Locator Implementation
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class FilesystemPathLocator implements PathLocatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function locateThemePath($description, $type = null)
    {
        if (preg_match('/^filesystem:(.+)$/', $description, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
