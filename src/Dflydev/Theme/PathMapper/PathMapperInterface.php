<?php

/*
 * This file is a part of dflydev/theme.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Theme\PathMapper;

use Dflydev\Theme\ThemeInterface;

/**
 * Path Mapper Interface
 *
 * Maps tempmlate system to the paths (filesystem and URL paths)
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface PathMapperInterface
{
    /**
     * Generate URL path for a theme name of a specific type
     *
     * Will always generate a value even if resource does not physically
     * exist on disk.
     *
     * @param string $themeName Theme name
     * @param string $type      Theme type
     *
     * @return string
     */
    public function generateUrlPath($themeName, $type = null);

    /**
     * Generate a filesystem path for a theme name of a specific type
     *
     * Will always generate a value even if resource does not physically
     * exist on disk.
     *
     * @param string $themeName Theme name
     * @param string $type      Theme type
     *
     * @return string
     */
    public function generateFilesystemPath($themeName, $type = null);

    /**
     * Generate URL for a Theme's public resource
     *
     * Will always generate a value even if resource does not physically
     * exist on disk.
     *
     * @param ThemeInterface $theme    Theme
     * @param string         $resource Resource
     *
     * @return string
     */
    public function generatePublicResourceUrlForTheme(ThemeInterface $theme, $resource);

    /**
     * Generate filesystem path for a Theme's public resource
     *
     * Will always generate a value even if resource does not physically
     * exist on disk.
     *
     * @param ThemeInterface $theme    Theme
     * @param string         $resource Resource
     *
     * @return string
     */
    public function generatePublicResourceFilesystemPathForTheme(ThemeInterface $theme, $resource);
}
