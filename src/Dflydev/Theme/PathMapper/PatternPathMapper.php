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

use Dflydev\PlaceholderResolver\DataSource\ArrayDataSource;
use Dflydev\PlaceholderResolver\RegexPlaceholderResolver;
use Dflydev\Theme\ThemeInterface;

/**
 * Pattern Path Mapper
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class PatternPathMapper implements PathMapperInterface
{
    /**
     * @var string
     */
    private $docroot;

    /**
     * @var string
     */
    private $themeUrlTemplate;

    /**
     * @var string
     */
    private $typedThemeUrlTemplate;

    /**
     * @var PlaceholderResolverInterface[]
     */
    private $placeholderResolvers;

    /**
     * Constructor
     *
     * @param string $docroot
     */
    public function __construct($docroot)
    {
        $this->docroot = $docroot;
    }

    /**
     * Set Theme URL template for non-typed themes
     *
     * @param string $themeUrlTemplate
     *
     * @return PatternPathMapper
     */
    public function setThemeUrlTemplate($themeUrlTemplate)
    {
        $this->themeUrlTemplate = $themeUrlTemplate;

        return $this;
    }

    /**
     * Set Theme URL template for typed themes
     *
     * @param string $typedThemeUrlTemplate
     *
     * @return PatternPathMapper
     */
    public function setTypedThemeUrlTemplate($typedThemeUrlTemplate)
    {
        $this->typedThemeUrlTemplate = $typedThemeUrlTemplate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUrlPath($themeName, $type = null)
    {
        $placeholderResolver = $this->placeholderResolver($themeName, $type);

        $themeUrlTemplate = null === $type ? $this->themeUrlTemplate : $this->typedThemeUrlTemplate;

        return $placeholderResolver->resolvePlaceholder($themeUrlTemplate);
    }

    /**
     * {@inheritdoc}
     */
    public function generateFilesystemPath($themeName, $type = null)
    {
        return $this->docroot.$this->generateUrlPath($themeName, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function generatePublicResourceUrlForTheme(ThemeInterface $theme, $resource)
    {
        $baseUrlPath = $this->generateUrlPath($theme->name(), $theme->type());
        $relativeResourceUrlPath = $theme->massageResource($this->docroot, $resource);

        return $baseUrlPath.$relativeResourceUrlPath;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePublicResourceFilesystemPathForTheme(ThemeInterface $theme, $resource)
    {
        $massagedResource = $theme->massageResource($this->docroot, $resource);
        if (0 !== strpos($massagedResource, '/')) {
            $massagedResource = '/'.$massagedResource;
        }

        return $this->generateFilesystemPath($theme->name(), $theme->type()).$massagedResource;
    }

    private function placeholderResolver($name, $type = null)
    {
        $key = $name.';type='.$type;
        if (isset($this->placeholderResolvers[$key])) {
            return $this->placeholderResolvers[$key];
        }

        $dataSource = new ArrayDataSource(array(
            'name' => $name,
            'type' => $type,
        ));

        return $this->placeholderResolvers[$key] = new RegexPlaceholderResolver($dataSource, '%', '%');
    }
}
