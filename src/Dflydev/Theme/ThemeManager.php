<?php

/*
 * This file is a part of dflydev/theme.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Theme;

use Dflydev\Theme\PathLocator\PathLocatorInterface;
use Dflydev\Theme\Registry\RegistryInterface;

/**
 * Theme Manager
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ThemeManager
{
    /**
     * Constructor
     *
     * @param RegistryInterface     $registry     Registry
     * @param PathLocatorInterface  $pathLocator  Path Locator
     * @param ThemeFactoryInterface $themeFactory Theme Factory
     */
    public function __construct(RegistryInterface $registry, PathLocatorInterface $pathLocator, ThemeFactoryInterface $themeFactory)
    {
        $this->registry = $registry;
        $this->pathLocator = $pathLocator;
        $this->themeFactory = $themeFactory;
    }

    /**
     * Register Theme
     *
     * @param string $descriptor Descriptor
     * @param string $type       Type
     *
     * @return ThemeInterface
     */
    public function registerTheme($descriptor, $type = null)
    {
        $path = $this->pathLocator->locateThemePath($descriptor, $type);
        $theme = $this->themeFactory->createTheme($path, $type);

        $this->registry->registerTheme($theme);

        return $theme;
    }

    /**
     * Get Themes
     *
     * @return ThemeInterface[]
     */
    public function getAllThemes()
    {
        return $this->registry->getAllThemes();
    }

    /**
     * Get Themes by type
     *
     * @param string $type
     *
     * @return ThemeInterface[]
     */
    public function getAllThemesByType($type = null)
    {
        return $this->registry->getAllThemesByType($type);
    }

    /**
     * Find Theme by name
     *
     * @param string $name
     * @param string $type
     *
     * @return ThemeInterface
     */
    public function findThemeByName($name, $type = null)
    {
        return $this->registry->findThemeByName($name, $type);
    }
}
