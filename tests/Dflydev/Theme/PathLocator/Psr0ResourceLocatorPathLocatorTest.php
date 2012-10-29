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
 * Psr0ResourceLocatorPathLocator Test
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class Psr0ResourceLocatorPathLocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test basic functionality
     */
    public function test()
    {
        $psr0ResourceLocator = $this->getMock('Dflydev\Psr0ResourceLocator\Psr0ResourceLocatorInterface');
        $psr0ResourceLocator
            ->expects($this->any())
            ->method('findFirstDirectory')
            ->with('Vendor\Package\Theme\Blue')
            ->will($this->returnValue('/path/to/project/vendor/vendor/package/resources/theme/blue'));

        $pathLocator = new Psr0ResourceLocatorPathLocator($psr0ResourceLocator);

        $this->assertEquals('/path/to/project/vendor/vendor/package/resources/theme/blue', $pathLocator->locateThemePath('namespace:Vendor\Package\Theme\Blue'));
        $this->assertNull($pathLocator->locateThemePath('name:vendor/blue'));
        $this->assertNull($pathLocator->locateThemePath('filesystem:/path/to/vendor/blue'));

        $this->assertEquals('/path/to/project/vendor/vendor/package/resources/theme/blue', $pathLocator->locateThemePath('namespace:Vendor\Package\Theme\Blue', 'admin'));
        $this->assertNull($pathLocator->locateThemePath('name:vendor/blue', 'admin'));
        $this->assertNull($pathLocator->locateThemePath('filesystem:/path/to/vendor/blue', 'admin'));
    }
}
