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
 * Theme Provider Interface
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface ThemeProviderInterface
{
    /**
     * Provide a Theme
     *
     * @return ThemeInterface
     */
    public function provideTheme();
}
