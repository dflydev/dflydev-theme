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
 * Path Locator Interface
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface PathLocatorInterface
{
    /**
     * Locate a theme path
     *
     * Implementations should return null in the case that either the
     * description is not supported or if the theme cannot be found
     * where the loader expects.
     *
     * @param string $description Theme description
     * @param string $type        Type of theme
     *
     * @return string
     */
    public function locateThemePath($description, $type = null);
}
