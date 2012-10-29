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
class CompositePathLocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test basic functionality
     */
    public function test()
    {
        $pathLocator000 = $this->getMock('Dflydev\Theme\PathLocator\PathLocatorInterface');
        $pathLocator001 = $this->getMock('Dflydev\Theme\PathLocator\PathLocatorInterface');
        $pathLocator002 = $this->getMock('Dflydev\Theme\PathLocator\PathLocatorInterface');

        $pathLocator000
            ->expects($this->any())
            ->method('locateThemePath')
            ->will($this->returnValueMap(array(
                array('myvendor/theme-000', null, '/path/to/myvendor/theme-000'),
                array('myvendor/theme-000', 'admin', '/path/to/admin/myvendor/theme-000'),
            )));

        $pathLocator001
            ->expects($this->any())
            ->method('locateThemePath')
            ->will($this->returnValueMap(array(
                array('myvendor/theme-001', null, '/path/to/myvendor/theme-001'),
                array('myvendor/theme-001', 'admin', '/path/to/admin/myvendor/theme-001'),
            )));

        $pathLocator002
            ->expects($this->any())
            ->method('locateThemePath')
            ->will($this->returnValueMap(array(
                array('myvendor/theme-002', null, '/path/to/myvendor/theme-002'),
                array('myvendor/theme-002', 'admin', '/path/to/admin/myvendor/theme-002'),
            )));

        $pathLocator = new CompositePathLocator(array($pathLocator000));
        $pathLocator->addPathLocator($pathLocator001);
        $pathLocator->addPathLocator($pathLocator002);

        $this->assertEquals('/path/to/myvendor/theme-000', $pathLocator->locateThemePath('myvendor/theme-000'));
        $this->assertEquals('/path/to/admin/myvendor/theme-000', $pathLocator->locateThemePath('myvendor/theme-000', 'admin'));

        $this->assertEquals('/path/to/myvendor/theme-001', $pathLocator->locateThemePath('myvendor/theme-001'));
        $this->assertEquals('/path/to/admin/myvendor/theme-001', $pathLocator->locateThemePath('myvendor/theme-001', 'admin'));

        $this->assertEquals('/path/to/myvendor/theme-002', $pathLocator->locateThemePath('myvendor/theme-002'));
        $this->assertEquals('/path/to/admin/myvendor/theme-002', $pathLocator->locateThemePath('myvendor/theme-002', 'admin'));

        $this->assertNull($pathLocator->locateThemePath('myvendor/theme-003'));
        $this->assertNull($pathLocator->locateThemePath('myvendor/theme-003', 'admin'));
    }
}
