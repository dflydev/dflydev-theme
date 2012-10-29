<?php

/*
 * This file is a part of dflydev/theme.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Theme\Format;

use Dflydev\Theme\ThemeInterface;

/**
 * Abstract Theme Format
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
abstract class AbstractThemeFormat implements ThemeInterface
{
    protected $rootPath;

    /**
     * {@inheritdoc}
     */
    public function rootPath()
    {
        return $this->rootPath;
    }
}
