<?php

// autoload_real.php @generated by Composer

<<<<<<< HEAD
class ComposerAutoloaderInit9877ca7a8a2a974dcdef2a3ccdf73803
=======
class ComposerAutoloaderInit611cb77422f46d43a0b1beb7b96612fb
>>>>>>> 8b0f23659ed5560358b12a79e6652f0704aaf95d
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

        require __DIR__ . '/platform_check.php';

<<<<<<< HEAD
        spl_autoload_register(array('ComposerAutoloaderInit9877ca7a8a2a974dcdef2a3ccdf73803', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader();
        spl_autoload_unregister(array('ComposerAutoloaderInit9877ca7a8a2a974dcdef2a3ccdf73803', 'loadClassLoader'));
=======
        spl_autoload_register(array('ComposerAutoloaderInit611cb77422f46d43a0b1beb7b96612fb', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader();
        spl_autoload_unregister(array('ComposerAutoloaderInit611cb77422f46d43a0b1beb7b96612fb', 'loadClassLoader'));
>>>>>>> 8b0f23659ed5560358b12a79e6652f0704aaf95d

        $useStaticLoader = PHP_VERSION_ID >= 50600 && !defined('HHVM_VERSION') && (!function_exists('zend_loader_file_encoded') || !zend_loader_file_encoded());
        if ($useStaticLoader) {
            require __DIR__ . '/autoload_static.php';

<<<<<<< HEAD
            call_user_func(\Composer\Autoload\ComposerStaticInit9877ca7a8a2a974dcdef2a3ccdf73803::getInitializer($loader));
=======
            call_user_func(\Composer\Autoload\ComposerStaticInit611cb77422f46d43a0b1beb7b96612fb::getInitializer($loader));
>>>>>>> 8b0f23659ed5560358b12a79e6652f0704aaf95d
        } else {
            $map = require __DIR__ . '/autoload_namespaces.php';
            foreach ($map as $namespace => $path) {
                $loader->set($namespace, $path);
            }

            $map = require __DIR__ . '/autoload_psr4.php';
            foreach ($map as $namespace => $path) {
                $loader->setPsr4($namespace, $path);
            }

            $classMap = require __DIR__ . '/autoload_classmap.php';
            if ($classMap) {
                $loader->addClassMap($classMap);
            }
        }

        $loader->register(true);

        if ($useStaticLoader) {
<<<<<<< HEAD
            $includeFiles = Composer\Autoload\ComposerStaticInit9877ca7a8a2a974dcdef2a3ccdf73803::$files;
=======
            $includeFiles = Composer\Autoload\ComposerStaticInit611cb77422f46d43a0b1beb7b96612fb::$files;
>>>>>>> 8b0f23659ed5560358b12a79e6652f0704aaf95d
        } else {
            $includeFiles = require __DIR__ . '/autoload_files.php';
        }
        foreach ($includeFiles as $fileIdentifier => $file) {
<<<<<<< HEAD
            composerRequire9877ca7a8a2a974dcdef2a3ccdf73803($fileIdentifier, $file);
=======
            composerRequire611cb77422f46d43a0b1beb7b96612fb($fileIdentifier, $file);
>>>>>>> 8b0f23659ed5560358b12a79e6652f0704aaf95d
        }

        return $loader;
    }
}

<<<<<<< HEAD
function composerRequire9877ca7a8a2a974dcdef2a3ccdf73803($fileIdentifier, $file)
=======
function composerRequire611cb77422f46d43a0b1beb7b96612fb($fileIdentifier, $file)
>>>>>>> 8b0f23659ed5560358b12a79e6652f0704aaf95d
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        require $file;

        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;
    }
}
