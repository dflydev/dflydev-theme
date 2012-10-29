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


/**
 * ArrayRegistry Test
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ArrayRegistryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test basic functionality
     */
    public function test()
    {
        $theme000 = $this->getMock('Dflydev\Theme\ThemeInterface');
        $theme001 = $this->getMock('Dflydev\Theme\ThemeInterface');
        $theme002 = $this->getMock('Dflydev\THeme\ThemeInterface');
        $theme003 = $this->getMock('Dflydev\THeme\ThemeInterface');
        $theme004 = $this->getMock('Dflydev\THeme\ThemeInterface');
        $theme005 = $this->getMock('Dflydev\THeme\ThemeInterface');

        $theme000
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('vendor/theme-000'));

        $theme001
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('vendor/theme-001'));
        $theme001
            ->expects($this->any())
            ->method('type')
            ->will($this->returnValue('admin'));

        $theme002
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('vendor/theme-002'));
        $theme002
            ->expects($this->any())
            ->method('type')
            ->will($this->returnValue('admin'));

        $theme003
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('vendor/theme-003'));
        $theme003
            ->expects($this->any())
            ->method('type')
            ->will($this->returnValue('store'));

        $theme004
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('vendor/theme-004'));
        $theme004
            ->expects($this->any())
            ->method('type')
            ->will($this->returnValue('store'));

        $theme005
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('vendor/theme-005'));

        $registry = new ArrayRegistry(array($theme000, $theme001));

        $this->assertCount(2, $registry->getAllThemes());
        $this->assertCount(1, $registry->getAllThemesByType('admin'));
        $this->assertCount(1, $registry->getAllThemesByType());

        $registry->registerTheme($theme000); // intentional, ensure no dupes
        $registry->registerTheme($theme001); // intentional, ensure no dupes
        $registry->registerTheme($theme002);
        $registry->registerTheme($theme003);
        $registry->registerTheme($theme004);
        $registry->registerTheme($theme005);

        $this->assertCount(6, $registry->getAllThemes());
        $this->assertCount(2, $registry->getAllThemesByType());
        $this->assertCount(2, $registry->getAllThemesByType('admin'));
        $this->assertCount(2, $registry->getAllThemesByType('store'));

        $this->assertEquals($theme000, $registry->findThemeByName('vendor/theme-000'));
        $this->assertEquals($theme001, $registry->findThemeByName('vendor/theme-001', 'admin'));
        $this->assertEquals($theme002, $registry->findThemeByName('vendor/theme-002', 'admin'));
        $this->assertEquals($theme003, $registry->findThemeByName('vendor/theme-003', 'store'));
        $this->assertEquals($theme004, $registry->findThemeByName('vendor/theme-004', 'store'));
        $this->assertEquals($theme005, $registry->findThemeByName('vendor/theme-005'));

        $this->assertNull($registry->findThemeByName('vendor/theme-000', 'anything'));
        $this->assertNull($registry->findThemeByName('vendor/theme-001', 'else'));
        $this->assertNull($registry->findThemeByName('vendor/theme-002'));
    }
}
