<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @group       cfhCompile
 * @group       cfhCompile_Loader
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_LoaderTest
extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        cfhCompile_Loader::registerAutoload(FALSE);
    }

    public function tearDown()
    {
        cfhCompile_Loader::registerAutoload();
    }

    public function testRegisterAutoload()
    {
        $callback = array('cfhCompile_Loader', 'autoload');
        // Check that we are not registered.
        $autoLoaders = spl_autoload_functions();
        if(!is_array($autoLoaders))
        {
            $autoLoaders = array();
        }
        $this->assertFalse(in_array($callback, $autoLoaders, TRUE));
        // Register
        cfhCompile_Loader::registerAutoload();
        $autoLoaders = spl_autoload_functions();
        $this->assertTrue(in_array($callback, $autoLoaders, TRUE));
        // Un register
        cfhCompile_Loader::registerAutoload(FALSE);
        $autoLoaders = spl_autoload_functions();
        $this->assertFalse(in_array($callback, $autoLoaders, TRUE));
    }

    public function testAutoload()
    {
        $this->assertFalse(cfhCompile_Loader::autoload('UNKNOWN_CLASS'));
        $this->assertEquals('cfhCompile_Loader', cfhCompile_Loader::autoload('cfhCompile_Loader'));
        if(!class_exists('cfhCompile_Exception', FALSE))
        {
            $this->assertEquals('cfhCompile_Exception', cfhCompile_Loader::autoload('cfhCompile_Exception'));
        }
        else
        {
            $this->markTestIncomplete('cfhCompile_Exception class has already been loaded.');
        }
    }

}