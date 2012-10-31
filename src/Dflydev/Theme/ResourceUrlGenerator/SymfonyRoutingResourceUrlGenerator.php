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

use Dflydev\Theme\ThemeProviderInterface;
use Dflydev\Theme\PathMapper\PathMapperInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Symfony Routing Resource URL Generator
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class SymfonyRoutingResourceUrlGenerator implements ResourceUrlGeneratorInterface
{
    /**
     * Typed Route Name
     *
     * The name of the route to be used when generating fallback URL
     * for non-typed themes.
     *
     * @var string
     */
    protected $typedRouteName = '_dflydev_typed_theme_handler';

    /**
     * Route Name
     *
     * The name of the route to be used when generating fallback URL
     * for typed themes.
     *
     * @var string
     */
    protected $routeName = '_dflydev_theme_handler';

    /**
     * Constructor
     *
     * @param ThemeProviderInterface $themeProvider Theme Provider
     * @param PathMapperInterface    $pathMapper    Path Mapper
     * @param UrlGeneratorInterface  $urlGenerator  URL Generator
     */
    public function __construct(ThemeProviderInterface $themeProvider, PathMapperInterface $pathMapper, UrlGeneratorInterface $urlGenerator)
    {
        $this->themeProvider = $themeProvider;
        $this->pathMapper = $pathMapper;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Set Typed Route Name
     *
     * @param string $typedRouteName
     *
     * @return ThemeTwigExtension
     */
    public function setTypedRouteName($typedRouteName)
    {
        $this->typedRouteName = $typedRouteName;

        return $this;
    }

    /**
     * Typed route name
     *
     * @return string
     */
    public function typedRouteName()
    {
        return $this->typedRouteName;
    }

    /**
     * Set Route Name
     *
     * @param string $routeName
     *
     * @return ThemeTwigExtension
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * Route name
     *
     * @return string
     */
    public function routeName()
    {
        return $this->routeName;
    }

    /**
     * {@inheritdoc}
     */
    public function generateResourceUrl($resource)
    {
        $theme = $this->themeProvider->provideTheme();

        $filesystemPath = $this->pathMapper->generatePublicResourceFilesystemPathForTheme($theme, $resource);

        if (file_exists($filesystemPath)) {
            return $this->pathMapper->generatePublicResourceUrlForTheme(
                $theme,
                $resource
            );
        }

        $resource = ltrim($resource, '/');

        if ($type = $theme->type()) {
            return $this->urlGenerator->generate($this->typedRouteName, array(
                'type' => $type,
                'name' => $theme->name(),
                'resource' => $resource,
            ));
        }

        return $this->urlGenerator->generate($this->routeName, array(
            'name' => $theme->name(),
            'resource' => $resource
        ));
    }
}
