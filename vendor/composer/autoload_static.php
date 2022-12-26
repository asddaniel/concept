<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit37b7b79e505183cd5835d70a0e113399
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit37b7b79e505183cd5835d70a0e113399::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit37b7b79e505183cd5835d70a0e113399::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit37b7b79e505183cd5835d70a0e113399::$classMap;

        }, null, ClassLoader::class);
    }
}
