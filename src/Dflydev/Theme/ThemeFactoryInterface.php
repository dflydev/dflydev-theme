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

/**
 * Theme Factory Interface
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface ThemeFactoryInterface
{
    /**
     * Create a Theme
     *
     * @param string $path
     * @param string $type
     *
     * @return ThemeInterface
     */
    public function createTheme($path, $type = null);
}
