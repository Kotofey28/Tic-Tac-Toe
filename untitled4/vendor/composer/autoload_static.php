<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit508e3dcdd5b5ecc73101e5294c4e3361
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Workerman\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Workerman\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/workerman',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit508e3dcdd5b5ecc73101e5294c4e3361::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit508e3dcdd5b5ecc73101e5294c4e3361::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit508e3dcdd5b5ecc73101e5294c4e3361::$classMap;

        }, null, ClassLoader::class);
    }
}
