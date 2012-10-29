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

/**
 * Version0ThemeFactory Test
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class Version0ThemeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test basic functionality
     */
    public function test()
    {
        $factory = new Version0ThemeFactory;

        $theme = $factory->createTheme(__DIR__.'/fixtures/myvendor/blue');
        $this->assertEquals('myvendor/blue', $theme->name());
        $this->assertNull($theme->type());

        $this->assertEquals('/style/main.css', $theme->massageResource('/foo/bar', '/style/main.css'));
        $this->assertEquals('/public/style/main.css', $theme->massageResource(__DIR__, '/style/main.css'));
        $this->assertEquals(__DIR__.'/fixtures/myvendor/blue', $theme->rootPath());

        $info = $theme->info();
        $this->assertEquals('Hello World', $info['_test']['message']);
    }

    /**
     * Test missing
     */
    public function testMissing()
    {
        $factory = new Version0ThemeFactory;

        try {
            $theme = $factory->createTheme(__DIR__.'/fixtures/myvendor/yellow');

            $this->fail('Expected missin');
        } catch (\InvalidArgumentException $e) {
            $this->assertContains("Invalid path specified for Version 0 theme; expected to find 'theme.json' at ", $e->getMessage());
        }
    }

    /**
     * Test mismatch type
     */
    public function testMismatchType()
    {
        $factory = new Version0ThemeFactory;

        try {
            $theme = $factory->createTheme(__DIR__.'/fixtures/myvendor/blue', 'admin');

            $this->fail('Expected type mismatch');
        } catch (\InvalidArgumentException $e) {
            $this->assertContains("Type mismatch specified for Version 0 theme; expected 'admin' but found type ''", $e->getMessage());
        }

        try {
            $theme = $factory->createTheme(__DIR__.'/fixtures/myvendor/green');

            $this->fail('Expected type mismatch');
        } catch (\InvalidArgumentException $e) {
            $this->assertContains("Type mismatch specified for Version 0 theme; expected '' but found type 'store'", $e->getMessage());
        }

        try {
            $theme = $factory->createTheme(__DIR__.'/fixtures/myvendor/green', 'admin');

            $this->fail('Expected type mismatch');
        } catch (\InvalidArgumentException $e) {
            $this->assertContains("Type mismatch specified for Version 0 theme; expected 'admin' but found type 'store'", $e->getMessage());
        }
    }
}
