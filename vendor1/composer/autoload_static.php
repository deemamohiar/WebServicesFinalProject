<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit82e6fcc2ff25f9f3ee236806e056b82e
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Ahc\\Jwt\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ahc\\Jwt\\' => 
        array (
            0 => __DIR__ . '/..' . '/adhocore/jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit82e6fcc2ff25f9f3ee236806e056b82e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit82e6fcc2ff25f9f3ee236806e056b82e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit82e6fcc2ff25f9f3ee236806e056b82e::$classMap;

        }, null, ClassLoader::class);
    }
}