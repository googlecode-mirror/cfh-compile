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
 * @group       cfhCompile_Compiler_Event
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_Compiler_EventTest
extends PHPUnit_Framework_TestCase
{

    /**
     * @var cfhCompile_Compiler_Event
     */
    protected $event;

    public function setUp()
    {
        $eventId       = cfhCompile_Compiler_Event::EVENT_BEGIN;
        $compiler      = $this->getMock('cfhCompile_Compiler');
        $classIterator = $this->getMock('cfhCompile_ClassIterator_Interface');
        $reader        = $this->getMock('cfhCompile_CodeReader_ReadStrategy_Interface');
        $writer        = $this->getMock('cfhCompile_CodeWriter_WriteStrategy_Interface');
        $registry      = $this->getMock('cfhCompile_ClassRegistry');
        $class         = $this->getMock('cfhCompile_Class_Interface');
        $this->event = new cfhCompile_Compiler_Event(
                                                    $eventId,
                                                    $compiler,
                                                    $classIterator,
                                                    $reader,
                                                    $writer,
                                                    $registry,
                                                    $class
                                                    );
    }

    public function testConstruction()
    {
        $eventId       = cfhCompile_Compiler_Event::EVENT_BEGIN;
        $compiler      = $this->getMock('cfhCompile_Compiler');
        $classIterator = $this->getMock('cfhCompile_ClassIterator_Interface');
        $reader        = $this->getMock('cfhCompile_CodeReader_ReadStrategy_Interface');
        $writer        = $this->getMock('cfhCompile_CodeWriter_WriteStrategy_Interface');
        $registry      = $this->getMock('cfhCompile_ClassRegistry');
        $class         = $this->getMock('cfhCompile_Class_Interface');
        $event         = new cfhCompile_Compiler_Event(
                                                    $eventId,
                                                    $compiler,
                                                    $classIterator,
                                                    $reader,
                                                    $writer,
                                                    $registry,
                                                    $class
                                                    );
        $this->assertSame($eventId      , $event->getEvent());
        $this->assertSame($compiler     , $event->getCompiler());
        $this->assertSame($classIterator, $event->getClassIterator());
        $this->assertSame($reader       , $event->getCodeReader());
        $this->assertSame($writer       , $event->getCodeWriter());
        $this->assertSame($registry     , $event->getClassRegistry());
        $this->assertSame($class        , $event->getClass());
        $this->assertNotEquals($this->event->getId(), $event->getId());
    }

    public function testCloneChangesId()
    {
        $clone = clone $this->event;
        $this->assertNotEquals($this->event->getId(), $clone->getId());
    }

    public function testSerializeThrowsException()
    {
        try
        {
            serialize($this->event);
        }
        catch(cfhCompile_Compiler_Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch cfhCompile_Compiler_Exception.');
    }

}