<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6d4ffbd8d16d3fc89e7fc84eee30585f
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DevWeb\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DevWeb\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'DevWeb\\Control\\Controller' => __DIR__ . '/../..' . '/app/Control/Controller.php',
        'DevWeb\\Control\\HomeController' => __DIR__ . '/../..' . '/app/Control/HomeController.php',
        'DevWeb\\Control\\NotFoundController' => __DIR__ . '/../..' . '/app/Control/NotFoundController.php',
        'DevWeb\\Model\\Usuario' => __DIR__ . '/../..' . '/app/Model/Usuario.php',
        'DevWeb\\Model\\mySQL' => __DIR__ . '/../..' . '/app/Model/mySQL.php',
        'DevWeb\\Route' => __DIR__ . '/../..' . '/app/Router.php',
        'DevWeb\\View\\Home' => __DIR__ . '/../..' . '/app/View/Home.php',
        'DevWeb\\View\\View' => __DIR__ . '/../..' . '/app/View/View.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6d4ffbd8d16d3fc89e7fc84eee30585f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6d4ffbd8d16d3fc89e7fc84eee30585f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6d4ffbd8d16d3fc89e7fc84eee30585f::$classMap;

        }, null, ClassLoader::class);
    }
}
