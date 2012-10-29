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
 * Theme Interface
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface ThemeInterface
{
    /**
     * Root path containing theme
     *
     * @return string
     */
    public function rootPath();

    /**
     * Type
     *
     * @return string|null
     */
    public function type();

    /**
     * Name
     *
     * @return string
     */
    public function name();

    /**
     * Massage the resource URL
     *
     * This is used to massage the actual location of the resource relative
     * to the Theme's root path. For example, if the root path does contains
     * the docroot, the resource can be transformed from '/css/a.css' to
     * '/public/css/a.css'.
     *
     * @param string $docroot  Docroot
     * @param string $resource Resource
     *
     * @return string
     */
    public function massageResource($docroot, $resource);
}
