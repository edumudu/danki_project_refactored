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
        'DevWeb\\Control\\ContactController' => __DIR__ . '/../..' . '/app/Control/ContactController.php',
        'DevWeb\\Control\\Controller' => __DIR__ . '/../..' . '/app/Control/Controller.php',
        'DevWeb\\Control\\HomeController' => __DIR__ . '/../..' . '/app/Control/HomeController.php',
        'DevWeb\\Control\\NewsController' => __DIR__ . '/../..' . '/app/Control/NewsController.php',
        'DevWeb\\Control\\NotFoundController' => __DIR__ . '/../..' . '/app/Control/NotFoundController.php',
        'DevWeb\\Control\\Panel\\CategoryController' => __DIR__ . '/../..' . '/app/Control/Panel/CategoryController.php',
        'DevWeb\\Control\\Panel\\ClientController' => __DIR__ . '/../..' . '/app/Control/Panel/ClientController.php',
        'DevWeb\\Control\\Panel\\ControllerPanel' => __DIR__ . '/../..' . '/app/Control/Panel/ControllerPanel.php',
        'DevWeb\\Control\\Panel\\DepoimentosController' => __DIR__ . '/../..' . '/app/Control/Panel/DepoimentosController.php',
        'DevWeb\\Control\\Panel\\NoticeController' => __DIR__ . '/../..' . '/app/Control/Panel/NoticeController.php',
        'DevWeb\\Control\\Panel\\PanelHomeController' => __DIR__ . '/../..' . '/app/Control/Panel/PanelHomeController.php',
        'DevWeb\\Control\\Panel\\ServiceController' => __DIR__ . '/../..' . '/app/Control/Panel/ServiceController.php',
        'DevWeb\\Control\\Panel\\SessionController' => __DIR__ . '/../..' . '/app/Control/Panel/SessionController.php',
        'DevWeb\\Control\\Panel\\SiteController' => __DIR__ . '/../..' . '/app/Control/Panel/SiteController.php',
        'DevWeb\\Control\\Panel\\SlideController' => __DIR__ . '/../..' . '/app/Control/Panel/SlideController.php',
        'DevWeb\\Control\\Panel\\UserController' => __DIR__ . '/../..' . '/app/Control/Panel/UserController.php',
        'DevWeb\\Model\\Category' => __DIR__ . '/../..' . '/app/Model/Category.php',
        'DevWeb\\Model\\Database\\DB' => __DIR__ . '/../..' . '/app/Model/Database/DB.php',
        'DevWeb\\Model\\Depoiment' => __DIR__ . '/../..' . '/app/Model/Depoiment.php',
        'DevWeb\\Model\\File' => __DIR__ . '/../..' . '/app/Model/File.php',
        'DevWeb\\Model\\Model' => __DIR__ . '/../..' . '/app/Model/Model.php',
        'DevWeb\\Model\\Notice' => __DIR__ . '/../..' . '/app/Model/Notice.php',
        'DevWeb\\Model\\Online' => __DIR__ . '/../..' . '/app/Model/Online.php',
        'DevWeb\\Model\\Painel' => __DIR__ . '/../..' . '/app/Model/Painel.php',
        'DevWeb\\Model\\Request' => __DIR__ . '/../..' . '/app/Model/Request.php',
        'DevWeb\\Model\\Service' => __DIR__ . '/../..' . '/app/Model/Service.php',
        'DevWeb\\Model\\Site' => __DIR__ . '/../..' . '/app/Model/Site.php',
        'DevWeb\\Model\\Slide' => __DIR__ . '/../..' . '/app/Model/Slide.php',
        'DevWeb\\Model\\User' => __DIR__ . '/../..' . '/app/Model/User.php',
        'DevWeb\\Model\\Visita' => __DIR__ . '/../..' . '/app/Model/Visita.php',
        'DevWeb\\Router' => __DIR__ . '/../..' . '/app/Router.php',
        'DevWeb\\View\\Home' => __DIR__ . '/../..' . '/app/View/Home.php',
        'DevWeb\\View\\Panel\\ViewPanel' => __DIR__ . '/../..' . '/app/View/Panel/ViewPanel.php',
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
