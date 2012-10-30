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
 * ThemeProvider Test
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ThemeProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Basic test
     */
    public function test()
    {
        $theme = $this->getMock('Dflydev\Theme\ThemeInterface');

        $themeProvider = new ThemeProvider($theme);

        $this->assertEquals($theme, $themeProvider->provideTheme());
    }
}
