<?php

/*
 * This file is a part of dflydev/theme.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Theme\PathLocator;

/**
 * Composite Path Locator Implementation
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class CompositePathLocator implements PathLocatorInterface
{
    /**
     * @var PathLocatorInterface
     */
    private $pathLocators;

    /**
     * Constructor
     *
     * @param array $pathLocators
     */
    public function __construct(array $pathLocators = array())
    {
        $this->pathLocators = $pathLocators;
    }

    /**
     * Add a Path Locator
     *
     * @param PathLocatorInterface $pathLocator
     *
     * @return CompositePathLocator
     */
    public function addPathLocator(PathLocatorInterface $pathLocator)
    {
        $this->pathLocators[] = $pathLocator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function locateThemePath($descriptor, $type = null)
    {
        foreach ($this->pathLocators as $pathLocator) {
            if (null !== $path = $pathLocator->locateThemePath($descriptor, $type)) {
                return $path;
            }
        }

        return null;
    }
}
