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
 * SymfonyRoutingResourceUrlGenerator Test
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class SymfonyRoutingResourceUrlGeneratorTest extends \PHPUnit_Framework_TestCase
{
    protected function createSymfonyResourceUrlGeneratorWithDeps()
    {
        $themeProvider = $this->getMock('Dflydev\Theme\ThemeProviderInterface');
        $pathMapper = $this->getMock('Dflydev\Theme\PathMapper\PathMapperInterface');
        $urlGenerator = $this->getMock('Symfony\Component\Routing\Generator\UrlGeneratorInterface');

        $resourceUrlGenerator = new SymfonyRoutingResourceUrlGenerator(
            $themeProvider,
            $pathMapper,
            $urlGenerator
        );

        return array($resourceUrlGenerator, $themeProvider, $pathMapper, $urlGenerator);
    }

    protected function createSymfonyResourceUrlGenerator()
    {
        $objects = $this->createSymfonyResourceUrlGeneratorWithDeps();

        return $objects[0];
    }

    /**
     * Test getting and setting route names
     */
    public function testRouteNames()
    {
        $resourceUrlGenerator = $this->createSymfonyResourceUrlGenerator();

        $this->assertEquals('_dflydev_typed_theme_handler', $resourceUrlGenerator->typedRouteName());
        $this->assertEquals('_dflydev_theme_handler', $resourceUrlGenerator->routeName());

        $resourceUrlGenerator->setTypedRouteName('theme_foo_typed');
        $resourceUrlGenerator->setRouteName('theme_foo');

        $this->assertEquals('theme_foo_typed', $resourceUrlGenerator->typedRouteName());
        $this->assertEquals('theme_foo', $resourceUrlGenerator->routeName());
    }

    /**
     * Test generateResourceUrl()
     */
    public function testGenerateResourceUrlPathMapperHandlesRequest()
    {
        list($resourceUrlGenerator, $themeProvider, $pathMapper, $urlGenerator) = $this->createSymfonyResourceUrlGeneratorWithDeps();

        $theme = $this->getMock('Dflydev\Theme\ThemeInterface');

        $theme
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('blue'));

        $themeProvider
            ->expects($this->any())
            ->method('provideTheme')
            ->will($this->returnValue($theme));

        $pathMapper
            ->expects($this->once())
            ->method('generatePublicResourceFilesystemPathForTheme')
            ->with($theme, 'css/main.css')
            ->will($this->returnValue(__DIR__.'/fixtures/non-typed-theme/blue/css/main.css'));

        $pathMapper
            ->expects($this->once())
            ->method('generatePublicResourceUrlForTheme')
            ->with($theme, 'css/main.css')
            ->will($this->returnValue('/non-typed-theme/blue/css/main.css'));

        $resourceUrl = $resourceUrlGenerator->generateResourceUrl('css/main.css');
        $this->assertEquals('/non-typed-theme/blue/css/main.css', $resourceUrl);
    }

    /**
     * Test generateResourceUrl()
     */
    public function testGenerateResourceUrlFallbackUrlGeneratedTyped()
    {
        list($resourceUrlGenerator, $themeProvider, $pathMapper, $urlGenerator) = $this->createSymfonyResourceUrlGeneratorWithDeps();

        $theme = $this->getMock('Dflydev\Theme\ThemeInterface');

        $theme
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('blue'));

        $theme
            ->expects($this->any())
            ->method('type')
            ->will($this->returnValue('admin'));

        $themeProvider
            ->expects($this->any())
            ->method('provideTheme')
            ->will($this->returnValue($theme));

        $pathMapper
            ->expects($this->once())
            ->method('generatePublicResourceFilesystemPathForTheme')
            ->with($theme, 'css/main.css')
            ->will($this->returnValue(__DIR__.'/missing-fixtures/typed-theme/blue/css/main.css'));

        $urlGenerator
            ->expects($this->once())
            ->method('generate')
            ->with('_dflydev_typed_theme_handler', array(
                'type' => 'admin',
                'name' => 'blue',
                'resource' => 'css/main.css',
            ))
            ->will($this->returnValue('/typed-theme/admin/blue/css/main.css'));

        $resourceUrl = $resourceUrlGenerator->generateResourceUrl('css/main.css');
        $this->assertEquals('/typed-theme/admin/blue/css/main.css', $resourceUrl);
    }

    /**
     * Test generateResourceUrl()
     */
    public function testGenerateResourceUrlFallbackUrlGeneratedNonTyped()
    {
        list($resourceUrlGenerator, $themeProvider, $pathMapper, $urlGenerator) = $this->createSymfonyResourceUrlGeneratorWithDeps();

        $theme = $this->getMock('Dflydev\Theme\ThemeInterface');

        $theme
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('blue'));

        $themeProvider
            ->expects($this->any())
            ->method('provideTheme')
            ->will($this->returnValue($theme));

        $pathMapper
            ->expects($this->once())
            ->method('generatePublicResourceFilesystemPathForTheme')
            ->with($theme, 'css/main.css')
            ->will($this->returnValue(__DIR__.'/missing-fixtures/typed-theme/blue/css/main.css'));

        $urlGenerator
            ->expects($this->once())
            ->method('generate')
            ->with('_dflydev_theme_handler', array(
                'name' => 'blue',
                'resource' => 'css/main.css',
            ))
            ->will($this->returnValue('/non-typed-theme/blue/css/main.css'));

        $resourceUrl = $resourceUrlGenerator->generateResourceUrl('css/main.css');
        $this->assertEquals('/non-typed-theme/blue/css/main.css', $resourceUrl);
    }

    /**
     * Test generateResourceUrl()
     */
    public function testGenerateResourceUrlLtrimmed()
    {
        list($resourceUrlGenerator, $themeProvider, $pathMapper, $urlGenerator) = $this->createSymfonyResourceUrlGeneratorWithDeps();

        $theme = $this->getMock('Dflydev\Theme\ThemeInterface');

        $theme
            ->expects($this->any())
            ->method('name')
            ->will($this->returnValue('blue'));

        $themeProvider
            ->expects($this->any())
            ->method('provideTheme')
            ->will($this->returnValue($theme));

        $pathMapper
            ->expects($this->once())
            ->method('generatePublicResourceFilesystemPathForTheme')
            ->with($theme, 'css/main.css')
            ->will($this->returnValue(__DIR__.'/missing-fixtures/typed-theme/blue/css/main.css'));

        $urlGenerator
            ->expects($this->once())
            ->method('generate')
            ->with('_dflydev_theme_handler', array(
                'name' => 'blue',
                'resource' => 'css/main.css',
            ))
            ->will($this->returnValue('/non-typed-theme/blue/css/main.css'));

        $resourceUrl = $resourceUrlGenerator->generateResourceUrl('/css/main.css');
        $this->assertEquals('/non-typed-theme/blue/css/main.css', $resourceUrl);
    }
}
