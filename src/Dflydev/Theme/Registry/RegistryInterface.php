<?php

/*
 * This file is a part of dflydev/theme.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Theme\Registry;

use Dflydev\Theme\ThemeInterface;

/**
 * Registry Interface
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface RegistryInterface
{
    /**
     * Register Theme
     *
     * @param ThemeInterface $theme
     *
     * @return RegistryInterface
     */
    public function registerTheme(ThemeInterface $theme);

    /**
     * Get registered Themes
     *
     * @return ThemeInterface[]
     */
    public function getAllThemes();

    /**
     * Get registered Themes by type
     *
     * @param string $type
     *
     * @return ThemeInterface[]
     */
    public function getAllThemesByType($type = null);

    /**
     * Find registered Theme by name
     *
     * @param string $name
     * @param string $type
     *
     * @return ThemeInterface
     */
    public function findThemeByName($name, $type = null);
}
