<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit85186c3678d1cc56f87de37b19a109e4
{
    public static $files = array (
        '3a37ebac017bc098e9a86b35401e7a68' => __DIR__ . '/..' . '/mongodb/mongodb/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Predis\\' => 7,
        ),
        'M' => 
        array (
            'MongoDB\\' => 8,
        ),
        'C' => 
        array (
            'Core\\' => 5,
        ),
        'A' => 
        array (
            'App\\' => 4,
            'Aliyun\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Predis\\' => 
        array (
            0 => __DIR__ . '/..' . '/predis/predis/src',
        ),
        'MongoDB\\' => 
        array (
            0 => __DIR__ . '/..' . '/mongodb/mongodb/src',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/..' . '/quezier/ezusephp-core',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Aliyun\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/Aliyunmsgapi',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Sunra\\PhpSimple\\HtmlDomParser' => 
            array (
                0 => __DIR__ . '/..' . '/sunra/php-simple-html-dom-parser/Src',
            ),
        ),
        'P' => 
        array (
            'Phpass' => 
            array (
                0 => __DIR__ . '/..' . '/rych/phpass/src',
            ),
            'PHPQRCode' => 
            array (
                0 => __DIR__ . '/..' . '/aferrandini/phpqrcode/lib',
            ),
            'PHPExcel' => 
            array (
                0 => __DIR__ . '/..' . '/phpoffice/phpexcel/Classes',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit85186c3678d1cc56f87de37b19a109e4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit85186c3678d1cc56f87de37b19a109e4::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit85186c3678d1cc56f87de37b19a109e4::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
