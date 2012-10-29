<?php

/*
 * This file is a part of dflydev/theme.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Theme\PathMapper;

/**
 * PatternPathMapper Test
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class PatternPathMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test basic functionality
     */
    public function test()
    {
        $docroot = __DIR__.'/fixtures/docroot';

        $pathMapper = new PatternPathMapper($docroot);
        $pathMapper->setThemeUrlTemplate('/themes/%name%');
        $pathMapper->setTypedThemeUrlTemplate('/themes/%type%/%name%');

        $this->assertEquals('/themes/sample/blue-theme', $pathMapper->generateUrlPath('sample/blue-theme'));
        $this->assertEquals('/themes/admin/sample/blue-theme', $pathMapper->generateUrlPath('sample/blue-theme', 'admin'));

        $this->assertEquals($docroot.'/themes/sample/blue-theme', $pathMapper->generateFilesystemPath('sample/blue-theme'));
        $this->assertEquals($docroot.'/themes/admin/sample/blue-theme', $pathMapper->generateFilesystemPath('sample/blue-theme', 'admin'));

        $standardTheme = $this->getMock('Dflydev\Theme\ThemeInterface');
        $standardTheme
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('sample/blue-theme'));
        $standardTheme
            ->expects($this->any())
            ->method('massageResource')
            ->with($docroot, '/css/style.css')
            ->will($this->returnValue('/public/css/style.css'));

        $this->assertEquals(
            '/themes/sample/blue-theme/public/css/style.css',
            $pathMapper->generatePublicResourceUrlForTheme($standardTheme, '/css/style.css')
        );

        $this->assertEquals(
            $docroot.'/themes/sample/blue-theme/public/css/style.css',
            $pathMapper->generatePublicResourceFilesystemPathForTheme($standardTheme, '/css/style.css')
        );

        $typedTheme = $this->getMock('Dflydev\Theme\ThemeInterface');
        $typedTheme
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('sample/blue-theme'));
        $typedTheme
            ->expects($this->any())
            ->method('type')
            ->will($this->returnValue('admin'));
        $typedTheme
            ->expects($this->any())
            ->method('massageResource')
            ->with($docroot, '/css/style.css')
            ->will($this->returnValue('/public/css/style.css'));

        $this->assertEquals(
            '/themes/admin/sample/blue-theme/public/css/style.css',
            $pathMapper->generatePublicResourceUrlForTheme($typedTheme, '/css/style.css')
        );

        $this->assertEquals(
            $docroot.'/themes/admin/sample/blue-theme/public/css/style.css',
            $pathMapper->generatePublicResourceFilesystemPathForTheme($typedTheme, '/css/style.css')
        );
    }
}
