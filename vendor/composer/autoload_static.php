<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfb9022d0f94c2c47ed91517cb6fe078a
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Duamaleek\\UnzipToS3\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Duamaleek\\UnzipToS3\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfb9022d0f94c2c47ed91517cb6fe078a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfb9022d0f94c2c47ed91517cb6fe078a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfb9022d0f94c2c47ed91517cb6fe078a::$classMap;

        }, null, ClassLoader::class);
    }
}
