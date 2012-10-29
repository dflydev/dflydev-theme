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

use Dflydev\Psr0ResourceLocator\Psr0ResourceLocatorInterface;

/**
 * PSR-0 Resource Locator Path Locator Implementation
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class Psr0ResourceLocatorPathLocator implements PathLocatorInterface
{
    /**
     * @var Psr0ResourceLocatorInterface
     */
    protected $psr0ResourceLocator;

    /**
     * Constructor
     *
     * @param Psr0ResourceLocator $psr0ResourceLocator
     */
    public function __construct(Psr0ResourceLocatorInterface $psr0ResourceLocator)
    {
        $this->psr0ResourceLocator = $psr0ResourceLocator;
    }

    /**
     * {@inheritdoc}
     */
    public function locateThemePath($description, $type = null)
    {
        if (!preg_match('/^namespace:(.+)$/', $description, $matches)) {
            return null;
        }

        return $this->psr0ResourceLocator->findFirstDirectory($matches[1]);
    }
}
