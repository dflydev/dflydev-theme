<?php

/*
 * This file is a part of dflydev/theme.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Theme\Format\Version0;

use Dflydev\Theme\ThemeFactoryInterface;

/**
 * Version 0 Theme Factory
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class Version0ThemeFactory implements ThemeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createTheme($path, $type = null)
    {
        $theme = new Version0ThemeFormat($path, $type);

        return $theme;
    }
}
