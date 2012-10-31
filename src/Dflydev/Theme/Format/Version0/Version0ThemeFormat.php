<?php

/*
 * This file is a part of dflydev/theme.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Theme\Format\Version0;

use Dflydev\Theme\Format\AbstractThemeFormat;

/**
 * Version 0 Theme Format
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class Version0ThemeFormat extends AbstractThemeFormat
{
    /**
     * @var array
     */
    protected $info;

    /**
     * Constructor
     *
     * @param string      $rootPath Root path
     * @param string|null $type     Type
     */
    public function __construct($rootPath, $type = null)
    {
        if (!file_exists($themeJsonFile = $rootPath.'/theme.json')) {
            throw new \InvalidArgumentException("Invalid path specified for Version 0 theme; expected to find 'theme.json' at '$themeJsonFile'.");
        }

        $themeJson = json_decode(file_get_contents($themeJsonFile), true);

        if (!isset($themeJson['type'])) {
            $themeJson['type'] = null;
        }

        if ($type !== $themeJson['type']) {
            throw new \InvalidArgumentException("Type mismatch specified for Version 0 theme; expected '$type' but found type '".$themeJson['type']."' in '$themeJsonFile'");
        }

        $this->rootPath = $rootPath;
        $this->info = $themeJson;
    }

    /**
     * Theme information from theme.json
     *
     * @return array
     */
    public function info()
    {
        return $this->info;
    }

    /**
     * {@inheritdoc}
     */
    public function type()
    {
        return $this->info['type'];
    }

    /**
     * {@inheritdoc}
     */
    public function name()
    {
        return $this->info['name'];
    }

    /**
     * {@inheritdoc}
     */
    public function massageResource($docroot, $resource)
    {
        if (0 === strpos($this->rootPath, $docroot)) {
            if (0 !== strpos($resource, '/')) {
                $resource = '/'.$resource;
            }
            return '/public'.$resource;
        }

        return $resource;
    }
}
