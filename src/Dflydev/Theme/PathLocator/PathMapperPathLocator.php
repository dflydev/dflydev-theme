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

use Dflydev\Theme\PathMapper\PathMapperInterface;

/**
 * Path Mapper Path Locator Implementation
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class PathMapperPathLocator implements PathLocatorInterface
{
    /**
     * @var PathMapperInterface
     */
    protected $pathMapper;

    /**
     * Constructor
     *
     * @param PathMapperInterface $pathMapper
     */
    public function __construct(PathMapperInterface $pathMapper)
    {
        $this->pathMapper = $pathMapper;
    }

    /**
     * {@inheritdoc}
     */
    public function locateThemePath($description, $type = null)
    {
        if (preg_match('/^name:(.+)$/', $description, $matches)) {
            $name = $matches[1];

            return $this->pathMapper->generateFilesystemPath($name, $type);
        }

        return null;
    }
}
