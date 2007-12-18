<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

error_reporting(E_ALL | E_STRICT);
chdir(dirname(__FILE__));

require_once 'PHPUnit/Util/Filter.php';
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

require_once '../library/cfhCompile/Loader.php';

PHPUnit_Util_Filter::addDirectoryToWhitelist(realpath('../library/'));
PHPUnit_Util_Filter::addFileToFilter(__FILE__);

cfhCompile_Loader::registerAutoload();

/**
 * Main Unit Test Class.
 *
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class AllTests
{

    public static function suite($dir = NULL)
    {
        $base = realpath(dirname(__FILE__));
        if($dir == __CLASS__)
        {
            $dir = $base;
        }
        $dir = realpath($dir);
        if(!is_dir($dir))
        {
            throw new UnexpectedValueException('$dir must be a valid directory.');
        }
        if($dir != $base)
        {
            $section = str_replace(
                                   DIRECTORY_SEPARATOR,
                                   '_',
                                   substr($dir, strlen($base) + 1)
                                  );
            $suite = new PHPUnit_Framework_TestSuite($section);
        }
        else
        {
            $section = '';
            $suite = new PHPUnit_Framework_TestSuite('cfhCompile');
        }
        foreach (new DirectoryIterator($dir) as $item)
        {
            if($item->isDot())
            {
                continue;
            }
            if($item->isFile())
            {
                if(substr($item->getBaseName('.php'), -4) == 'Test')
                {
                    if($section)
                    {
                        $testClass = $section.'_'.$item->getBaseName('.php');
                    }
                    else
                    {
                        $testClass = $item->getBaseName('.php');
                    }
                    require_once $item->getPathName();
                    $suite->addTestSuite($testClass);
                }
            }
            elseif($item->isDir())
            {
                if(substr($item->getBaseName(), 0, 1) != '_')
                {
                    $suite->addTest(self::suite($item->getPathName()));
                }
            }
        }
        return $suite;
    }

}
