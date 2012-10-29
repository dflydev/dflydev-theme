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
 * FilesystemPathLocator Test
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class FilesystemPathLocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test basic functionality
     */
    public function test()
    {
        $pathLocator = new FilesystemPathLocator;

        $this->assertEquals('/path/to/docroot/themes/vendor/blue', $pathLocator->locateThemePath('filesystem:/path/to/docroot/themes/vendor/blue'));
        $this->assertNull($pathLocator->locateThemePath('name:vendor/blue'));
        $this->assertNull($pathLocator->locateThemePath('namespace:Vendor\Package\Theme\Blue'));
    }
}
