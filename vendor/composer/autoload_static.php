<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit700e83eb33371cbb6b70bafb988fa8ae
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit700e83eb33371cbb6b70bafb988fa8ae::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit700e83eb33371cbb6b70bafb988fa8ae::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit700e83eb33371cbb6b70bafb988fa8ae::$classMap;

        }, null, ClassLoader::class);
    }
}
