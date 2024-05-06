<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit0d2adee232bf0303f5fce482d15d4196
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit0d2adee232bf0303f5fce482d15d4196', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit0d2adee232bf0303f5fce482d15d4196', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit0d2adee232bf0303f5fce482d15d4196::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}