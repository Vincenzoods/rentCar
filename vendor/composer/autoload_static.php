<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit61a6f01e7a17a4a3d4cecbc069e662d7
{
    public static $files = array (
        '253c157292f75eb38082b5acb06f3f01' => __DIR__ . '/..' . '/nikic/fast-route/src/functions.php',
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        '6f2c5977e422114bbaec553e7c77ee8b' => __DIR__ . '/..' . '/http-interop/response-sender/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'Zend\\Expressive\\Router\\' => 23,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
        ),
        'F' => 
        array (
            'Fig\\Http\\Message\\' => 17,
            'FastRoute\\' => 10,
        ),
        'C' => 
        array (
            'Core\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Zend\\Expressive\\Router\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-expressive-fastroute/src',
            1 => __DIR__ . '/..' . '/zendframework/zend-expressive-router/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-factory/src',
            1 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'Fig\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/fig/http-message-util/src',
        ),
        'FastRoute\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/fast-route/src',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit61a6f01e7a17a4a3d4cecbc069e662d7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit61a6f01e7a17a4a3d4cecbc069e662d7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit61a6f01e7a17a4a3d4cecbc069e662d7::$classMap;

        }, null, ClassLoader::class);
    }
}