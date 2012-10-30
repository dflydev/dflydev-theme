<?php

/*
 * This file is a part of dflydev/theme.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Theme\ResourceUrlGenerator;

/**
 * Resource URL Generator Interface
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface ResourceUrlGeneratorInterface
{
    /**
     * Generate a URL for a Theme's resource
     *
     * If the actual file representing the resource exists where the path
     * mapper says it should exist then a URL is created to that location.
     * Otherwise, a fallback URL should be created.
     *
     * @param string $resource
     *
     * @return string
     */
    public function generateResourceUrl($resource);
}
