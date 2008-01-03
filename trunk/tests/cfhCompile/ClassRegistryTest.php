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
 * @group       cfhCompile_ClassRegistry
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_ClassRegistryTest
extends PHPUnit_Framework_TestCase
{

    protected $mockClass;

    public function setUp()
    {
        $this->mockClass = $this->getMock('cfhCompile_Class_Interface');
        $this->mockClass->expects($this->any())
                        ->method('getName')
                        ->will($this->returnValue('Test'))
                        ;
    }

    public function testRegisterReturnsSameObject()
    {
        $r = new cfhCompile_ClassRegistry();
        $this->assertSame($this->mockClass, $r->register($this->mockClass));
        $this->assertEquals(1, $r->count());
    }

    public function testRegisterSameClassMoreThanOnceOK()
    {
        $r = new cfhCompile_ClassRegistry();
        $this->assertSame($this->mockClass, $r->register($this->mockClass));
        $this->assertSame($this->mockClass, $r->register($this->mockClass));
        $this->assertEquals(1, $r->count());
    }

    public function testRegisterConflectingClassError()
    {
        $badMockClass = $this->getMock('cfhCompile_Class_Interface');
        $badMockClass->expects($this->any())
                     ->method('getName')
                     ->will($this->returnValue('Test'))
                     ;
        $r = new cfhCompile_ClassRegistry();
        $this->assertSame($this->mockClass, $r->register($this->mockClass));
        try {
            $r->register($badMockClass);
        }
        catch (cfhCompile_ClassRegistry_Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch cfhCompile_ClassRegistry_Exception.');
    }

    public function testFetchReturnsNullForUnknownClassName()
    {
        $r = new cfhCompile_ClassRegistry();
        $this->assertNull($r->fetch('UNKNOWN'));
    }

    public function testClear()
    {
        $r = new cfhCompile_ClassRegistry();
        $this->assertNull($r->fetch('Test'));
        $r->register($this->mockClass);
        $this->assertSame($this->mockClass, $r->fetch('Test'));
        $this->assertEquals(1, $r->count());
        $r->clear();
        $this->assertNull($r->fetch('Test'));
        $this->assertEquals(0, $r->count());
    }

    public function testGetIterator()
    {
        $r = new cfhCompile_ClassRegistry();
        $r->register($this->mockClass);
        foreach($r as $k=>$v){
            $this->assertEquals('Test', $k);
            $this->assertSame($this->mockClass, $v);
        }
    }

}