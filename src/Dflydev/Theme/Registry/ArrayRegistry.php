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
 * Array Registry
 *
 * Very simple implementation of the Registry Interface. Intended to be used
 * in systems where the Themes are registered at runtime each time the code
 * is executed.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ArrayRegistry implements RegistryInterface
{
    /**
     * Constructor
     *
     * @param array $array
     */
    public function __construct(array $array = array())
    {
        $this->array = $array;
    }

    /**
     * {@inheritdoc}
     */
    public function registerTheme(ThemeInterface $theme)
    {
        if (in_array($theme, $this->array)) {
            return $this;
        }

        $this->array[] = $theme;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllThemes($type = null)
    {
        return $this->array;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllThemesByType($type = null)
    {
        $themes = array();

        foreach ($this->array as $theme) {
            if ($theme->type() === $type) {
                $themes[] = $theme;
            }

        }

        return $themes;
    }

    /**
     * {@inheritdoc}
     */
    public function findThemeByName($name, $type = null)
    {
        foreach ($this->array as $theme) {
            if ($theme->type() === $type && $theme->name() === $name) {
                return $theme;
            }
        }

        return null;
    }
}
