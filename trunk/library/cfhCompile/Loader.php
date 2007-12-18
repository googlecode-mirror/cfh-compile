<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * Class loader.
 *
 * @category    cfh
 * @package     cfhCompile
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_Loader
{

    static protected $basePath;

    /**
     * Loads a class from a PHP file.  The filename must be formatted
     * as "$class.php".
     *
     * @param string $class
     * @return void
     * @throws RuntimeException
     */
    public static function loadClass($class)
    {
        if(class_exists($class, false) || interface_exists($class, false))
        {
            return;
        }
        if(!self::$basePath)
        {
            self::$basePath = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..').DIRECTORY_SEPARATOR;
        }
        $file     = str_replace('_', DIRECTORY_SEPARATOR, $class).'.php';
        $pathName = self::$basePath.$file;
        if(!is_file($pathName))
        {
            throw new RuntimeException('Unable to load class "'.$class.'" as file "'.$file.'" does not exist.');
        }
        if(!@is_readable($pathName))
        {
            throw new RuntimeException('Unable to load class "'.$class.'" as file "'.$file.'" is not readable.');
        }
        require $pathName;
        if(!class_exists($class, false) && !interface_exists($class, false))
        {
            throw new RuntimeException('File "'.$file.'" was loaded but class "'.$class.'" was not found in the file.');
        }
    }

    /**
     * spl_autoload() suitable implementation for supporting class autoloading.
     *
     * Attach to spl_autoload() using the following:
     * <code>
     * spl_autoload_register(array('cfhCompile_Loader', 'autoload'));
     * </code>
     *
     * @param string $class
     * @return string|false Class name on success; false on failure
     */
    public static function autoload($class)
    {
        try {
            self::loadClass($class);
            return $class;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /**
     * Register {@link autoload()} with spl_autoload()
     *
     * @param boolean OPTIONAL $enabled
     * @return void
     * @throws RuntimeException if spl_autoload() is not found
     */
    public static function registerAutoload($enabled = TRUE)
    {
        if (!function_exists('spl_autoload_register'))
        {
            throw new RuntimeException('spl_autoload does not exist in this PHP installation.');
        }
        if($enabled === TRUE)
        {
            spl_autoload_register(array(__CLASS__, 'autoload'));
        }
        else
        {
            spl_autoload_unregister(array(__CLASS__, 'autoload'));
        }
    }

}