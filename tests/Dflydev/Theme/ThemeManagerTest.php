<?php

/*
 * This file is a part of dflydev/theme.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Theme;

/**
 * ThemeManager Test
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ThemeManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test register theme
     */
    public function testRegisterTheme()
    {
        $theme = $this->getMock('Dflydev\Theme\ThemeInterface');

        $theme
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('myvendor/blue'));

        $registry = $this->getMock('Dflydev\Theme\Registry\RegistryInterface');

        $registry
            ->expects($this->once())
            ->method('registerTheme')
            ->with($theme);

        $pathLocator = $this->getMock('Dflydev\Theme\PathLocator\PathLocatorInterface');

        $pathLocator
            ->expects($this->once())
            ->method('locateThemePath')
            ->with('name:myvendor/blue')
            ->will($this->returnValue('/path/to/myvendor/blue'));

        $themeFactory = $this->getMock('Dflydev\Theme\ThemeFactoryInterface');

        $themeFactory
            ->expects($this->once())
            ->method('createTheme')
            ->with('/path/to/myvendor/blue')
            ->will($this->returnValue($theme));

        $manager = new ThemeManager($registry, $pathLocator, $themeFactory);

        $registeredTheme = $manager->registerTheme('name:myvendor/blue');

        $this->assertEquals($registeredTheme, $theme);
    }

    /**
     * Test register theme
     */
    public function testRegistry()
    {
        $theme000 = $this->getMock('Dflydev\Theme\ThemeInterface');
        $theme000
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('myvendor/theme-000'));

        $theme001 = $this->getMock('Dflydev\Theme\ThemeInterface');
        $theme001
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('myvendor/theme-001'));

        $theme002 = $this->getMock('Dflydev\Theme\ThemeInterface');
        $theme002
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('myvendor/theme-002'));

        $theme003 = $this->getMock('Dflydev\Theme\ThemeInterface');
        $theme003
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('myvendor/theme-003'));

        $theme004 = $this->getMock('Dflydev\Theme\ThemeInterface');
        $theme004
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('myvendor/theme-004'));

        $registry = $this->getMock('Dflydev\Theme\Registry\RegistryInterface');

        $registry
            ->expects($this->once())
            ->method('getAllThemes')
            ->will($this->returnValue(array($theme000, $theme001, $theme002, $theme003, $theme004)));

        $registry
            ->expects($this->at(1))
            ->method('getAllThemesByType')
            ->will($this->returnValue(array($theme000)));

        $registry
            ->expects($this->at(2))
            ->method('getAllThemesByType')
            ->with('admin')
            ->will($this->returnValue(array($theme001, $theme002)));

        $registry
            ->expects($this->at(3))
            ->method('getAllThemesByType')
            ->with('store')
            ->will($this->returnValue(array($theme003, $theme004)));
        $registry
            ->expects($this->any())
            ->method('findThemeByName')
            ->will($this->returnValueMap(array(
                array('myvendor/theme-000', null, $theme000,),
                array('myvendor/theme-001', 'admin', $theme001,),
                array('myvendor/theme-003', 'store', $theme003,),
            )));

        $pathLocator = $this->getMock('Dflydev\Theme\PathLocator\PathLocatorInterface');
        $themeFactory = $this->getMock('Dflydev\Theme\ThemeFactoryInterface');

        $manager = new ThemeManager($registry, $pathLocator, $themeFactory);

        $this->assertCount(5, $manager->getAllThemes());

        $this->assertCount(1, $themes = $manager->getAllThemesByType());
        $this->assertEquals($theme000->name(), $themes[0]->name());

        $this->assertCount(2, $themes = $manager->getAllThemesByType('admin'));
        $this->assertEquals($theme001->name(), $themes[0]->name());
        $this->assertEquals($theme002->name(), $themes[1]->name());

        $this->assertCount(2, $themes = $manager->getAllThemesByType('store'));
        $this->assertEquals($theme003->name(), $themes[0]->name());
        $this->assertEquals($theme004->name(), $themes[1]->name());

        $this->assertEquals($theme000->name(), $manager->findThemeByName('myvendor/theme-000')->name());
        $this->assertEquals($theme000->name(), $manager->findThemeByName('myvendor/theme-000', null)->name());
        $this->assertEquals($theme001->name(), $manager->findThemeByName('myvendor/theme-001', 'admin')->name());
        $this->assertEquals($theme003->name(), $manager->findThemeByName('myvendor/theme-003', 'store')->name());

        $this->assertNull($manager->findThemeByName('myvendor/theme-000', 'wrong'));
        $this->assertNull($manager->findThemeByName('myvendor/theme-001', 'wrong'));
        $this->assertNull($manager->findThemeByName('myvendor/theme-003', 'wrong'));
    }
}
