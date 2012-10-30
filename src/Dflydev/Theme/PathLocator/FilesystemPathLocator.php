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
    public function locateThemePath($descriptor, $type = null)
    {
        if (preg_match('/^filesystem:(.+)$/', $descriptor, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
