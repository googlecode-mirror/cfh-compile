<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @group       cfhCompile
 * @group       cfhCompile_Compiler
 * @group       cfhCompile_Compiler_Observer
 * @group       cfhCompile_Compiler_Observer_SimpleLogger
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_Compiler_Observer_SimpleLoggerTest
extends PHPUnit_Framework_TestCase
{

    public function testInvalidResourceThrowsException()
    {
        try
        {
            new cfhCompile_Compiler_Observer_SimpleLogger(NULL);
        }
        catch(InvalidArgumentException $e)
        {
            return;
        }
        $this->fail('Expecting to catch InvalidArgumentException');
    }

    public function testNotifyBegin()
    {
        $event = new cfhCompile_Compiler_Event(
                                              cfhCompile_Compiler_Event::EVENT_BEGIN,
                                              new cfhCompile_Compiler(),
                                              new cfhCompile_ClassIterator_Declared(),
                                              new cfhCompile_CodeReader(),
                                              new cfhCompile_CodeWriter(),
                                              new cfhCompile_ClassRegistry(),
                                              NULL
                                              );
        ob_start();
        $fp = fopen('php://output', 'r');
        $o  = new cfhCompile_Compiler_Observer_SimpleLogger($fp);
        $o->notify($event);
        fclose($fp);
        $this->assertEquals('BEGIN'.PHP_EOL, ob_get_clean());
    }

    public function testNotifyClass()
    {
        $event = new cfhCompile_Compiler_Event(
                                              cfhCompile_Compiler_Event::EVENT_CLASS,
                                              new cfhCompile_Compiler(),
                                              new cfhCompile_ClassIterator_Declared(),
                                              new cfhCompile_CodeReader(),
                                              new cfhCompile_CodeWriter(),
                                              new cfhCompile_ClassRegistry(),
                                              new cfhCompile_Class_Reflection($this)
                                              );
        ob_start();
        $fp = fopen('php://output', 'r');
        $o  = new cfhCompile_Compiler_Observer_SimpleLogger($fp);
        $o->notify($event);
        fclose($fp);
        $this->assertEquals('CLASS '.get_class($this).PHP_EOL, ob_get_clean());
    }

    public function testNotifyCommit()
    {
        $event = new cfhCompile_Compiler_Event(
                                              cfhCompile_Compiler_Event::EVENT_COMMIT,
                                              new cfhCompile_Compiler(),
                                              new cfhCompile_ClassIterator_Declared(),
                                              new cfhCompile_CodeReader(),
                                              new cfhCompile_CodeWriter(),
                                              new cfhCompile_ClassRegistry(),
                                              NULL
                                              );
        ob_start();
        $fp = fopen('php://output', 'r');
        $o  = new cfhCompile_Compiler_Observer_SimpleLogger($fp);
        $o->notify($event);
        fclose($fp);
        $this->assertEquals('COMMIT'.PHP_EOL, ob_get_clean());
    }

    public function testNotifyRolback()
    {
        $event = new cfhCompile_Compiler_Event(
                                              cfhCompile_Compiler_Event::EVENT_ROLLBACK,
                                              new cfhCompile_Compiler(),
                                              new cfhCompile_ClassIterator_Declared(),
                                              new cfhCompile_CodeReader(),
                                              new cfhCompile_CodeWriter(),
                                              new cfhCompile_ClassRegistry(),
                                              NULL
                                              );
        ob_start();
        $fp = fopen('php://output', 'r');
        $o  = new cfhCompile_Compiler_Observer_SimpleLogger($fp);
        $o->notify($event);
        fclose($fp);
        $this->assertEquals('ROLLBACK'.PHP_EOL, ob_get_clean());
    }

    public function testNotifySkip()
    {
        $event = new cfhCompile_Compiler_Event(
                                              cfhCompile_Compiler_Event::EVENT_SKIP,
                                              new cfhCompile_Compiler(),
                                              new cfhCompile_ClassIterator_Declared(),
                                              new cfhCompile_CodeReader(),
                                              new cfhCompile_CodeWriter(),
                                              new cfhCompile_ClassRegistry(),
                                              new cfhCompile_Class_Reflection($this)
                                              );
        ob_start();
        $fp = fopen('php://output', 'r');
        $o  = new cfhCompile_Compiler_Observer_SimpleLogger($fp);
        $o->notify($event);
        fclose($fp);
        $this->assertEquals('SKIP '.get_class($this).PHP_EOL, ob_get_clean());
    }

    public function testNotifyWrite()
    {
        $event = new cfhCompile_Compiler_Event(
                                              cfhCompile_Compiler_Event::EVENT_WRITE,
                                              new cfhCompile_Compiler(),
                                              new cfhCompile_ClassIterator_Declared(),
                                              new cfhCompile_CodeReader(),
                                              new cfhCompile_CodeWriter(),
                                              new cfhCompile_ClassRegistry(),
                                              new cfhCompile_Class_Reflection($this)
                                              );
        ob_start();
        $fp = fopen('php://output', 'r');
        $o  = new cfhCompile_Compiler_Observer_SimpleLogger($fp);
        $o->notify($event);
        fclose($fp);
        $this->assertEquals('WRITE '.get_class($this).PHP_EOL, ob_get_clean());
    }

    public function testNotifyNotFound()
    {
        $event = new cfhCompile_Compiler_Event(
                                              cfhCompile_Compiler_Event::EVENT_NOTFOUND,
                                              new cfhCompile_Compiler(),
                                              new cfhCompile_ClassIterator_Declared(),
                                              new cfhCompile_CodeReader(),
                                              new cfhCompile_CodeWriter(),
                                              new cfhCompile_ClassRegistry(),
                                              new cfhCompile_Class_Reflection($this)
                                              );
        ob_start();
        $fp = fopen('php://output', 'r');
        $o  = new cfhCompile_Compiler_Observer_SimpleLogger($fp);
        $o->notify($event);
        fclose($fp);
        $this->assertEquals('NOTFOUND '.get_class($this).PHP_EOL, ob_get_clean());
    }


}