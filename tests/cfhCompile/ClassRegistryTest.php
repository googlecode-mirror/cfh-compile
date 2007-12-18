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
 * @group       cfhCompile_ClassRegistry
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_ClassRegistryTest
extends PHPUnit_Framework_TestCase
{

    protected $mockClass;

    public function setUp()
    {
        cfhCompile_ClassRegistry::getInstance()->clear();
        $this->mockClass = $this->getMock('cfhCompile_Class_Interface');
        $this->mockClass->expects($this->any())
                        ->method('getName')
                        ->will($this->returnValue('Test'))
                        ;
    }

    public function tearDown()
    {
        cfhCompile_ClassRegistry::getInstance()->clear();
    }

    public function testRegisterReturnsSameObject()
    {
        $r = cfhCompile_ClassRegistry::getInstance();
        $this->assertSame($this->mockClass, $r->register($this->mockClass));
    }

    public function testRegisterSameClassMoreThanOnceOK()
    {
        $r = cfhCompile_ClassRegistry::getInstance();
        $this->assertSame($this->mockClass, $r->register($this->mockClass));
        $this->assertSame($this->mockClass, $r->register($this->mockClass));
    }

    public function testRegisterConflectingClassError()
    {
        $badMockClass = $this->getMock('cfhCompile_Class_Interface');
        $badMockClass->expects($this->any())
                     ->method('getName')
                     ->will($this->returnValue('Test'))
                     ;
        $r = cfhCompile_ClassRegistry::getInstance();
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
        $r = cfhCompile_ClassRegistry::getInstance();
        $this->assertNull($r->fetch('UNKNOWN'));
    }

    public function testClear()
    {
        $r = cfhCompile_ClassRegistry::getInstance();
        $this->assertNull($r->fetch('Test'));
        $r->register($this->mockClass);
        $this->assertSame($this->mockClass, $r->fetch('Test'));
        $r->clear();
        $this->assertNull($r->fetch('Test'));
    }

    public function testGetIterator()
    {
        $r = cfhCompile_ClassRegistry::getInstance();
        $r->register($this->mockClass);
        foreach($r as $k=>$v){
            $this->assertEquals('Test', $k);
            $this->assertSame($this->mockClass, $v);
        }
    }

}