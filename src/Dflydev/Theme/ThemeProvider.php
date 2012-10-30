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
 * Theme Provider Implementation
 *
 * This basic implementation can be used when there is no logic needed
 * to provide a theme and the theme can be defined and injected easily
 * when the Theme Provider is instantiated.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ThemeProvider implements ThemeProviderInterface
{
    /**
     * @var ThemeInterface
     */
    private $theme;

    /**
     * Constructor
     *
     * @param ThemeInterface $theme
     */
    public function __construct(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }

    /**
     * {@inheritdoc}
     */
    public function provideTheme()
    {
        return $this->theme;
    }
}
