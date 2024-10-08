<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit027fa576927c3f615def3e7f0ca3a110
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

        spl_autoload_register(array('ComposerAutoloaderInit027fa576927c3f615def3e7f0ca3a110', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit027fa576927c3f615def3e7f0ca3a110', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit027fa576927c3f615def3e7f0ca3a110::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
