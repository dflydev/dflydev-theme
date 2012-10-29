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
 * PathMapperPathLocator Test
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class PathMapperPathLocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test basic functionality
     */
    public function test()
    {
        $pathMapper = $this->getMock('Dflydev\Theme\PathMapper\PathMapperInterface');
        $pathMapper
            ->expects($this->once())
            ->method('generateFilesystemPath')
            ->with('vendor/blue')
            ->will($this->returnValue('/path/to/docroot/themes/vendor/blue'));


        $pathLocator = new PathMapperPathLocator($pathMapper);

        $this->assertEquals('/path/to/docroot/themes/vendor/blue', $pathLocator->locateThemePath('name:vendor/blue'));
        $this->assertNull($pathLocator->locateThemePath('filesystem:/path/to/vendor/blue'));
        $this->assertNull($pathLocator->locateThemePath('namespace:Vendor\Package\Theme\Blue'));

        $pathMapper = $this->getMock('Dflydev\Theme\PathMapper\PathMapperInterface');
        $pathMapper
            ->expects($this->once())
            ->method('generateFilesystemPath')
            ->with('vendor/blue', 'admin')
            ->will($this->returnValue('/path/to/docroot/themes/admin/vendor/blue'));


        $pathLocator = new PathMapperPathLocator($pathMapper);

        $this->assertEquals('/path/to/docroot/themes/admin/vendor/blue', $pathLocator->locateThemePath('name:vendor/blue', 'admin'));
        $this->assertNull($pathLocator->locateThemePath('filesystem:/path/to/vendor/blue', 'admin'));
        $this->assertNull($pathLocator->locateThemePath('namespace:Vendor\Package\Theme\Blue', 'admin'));
    }
}
