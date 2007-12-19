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
 * @group       cfhCompile_Class
 * @group       cfhCompile_Class_Reflection
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_Class_ReflectionTest
extends PHPUnit_Framework_TestCase
{

    public function testConstructorObject()
    {
        $c = new cfhCompile_Class_Reflection($this);
        $this->assertEquals(get_class($this), $c->getName());
    }

    public function testConstructorString()
    {
        $className = get_class($this);
        $c = new cfhCompile_Class_Reflection($className);
        $this->assertEquals($className, $c->getName());
    }

    public function testConstructorInvalidArgument()
    {
        try
        {
            new cfhCompile_Class_Reflection(NULL);
        }
        catch(InvalidArgumentException $e)
        {
            return;
        }
        $this->fail('Expecting to catch InvalidArgumentException');
    }

    public function testConstructorInvalidString()
    {
        try
        {
            new cfhCompile_Class_Reflection('INVALID');
        }
        catch(ReflectionException $e)
        {
            return;
        }
        $this->fail('Expecting to catch ReflectionException');
    }

    public function testInternalClass()
    {
        $c = new cfhCompile_Class_Reflection('SplFileObject');
        $this->assertEquals('SplFileObject', $c->getName());
        $this->assertNull($c->getFileName());
        $this->assertNull($c->getStartLine());
        $this->assertNull($c->getEndLine());
        $this->assertFalse($c->isInterface());
        $deps = $c->getDependancys();
        $this->assertTrue(count($deps) == 5);
        $this->assertEquals('SplFileInfo', current($deps));
        $this->assertEquals('RecursiveIterator', next($deps));
        $this->assertEquals('Traversable', next($deps));
        $this->assertEquals('Iterator', next($deps));
        $this->assertEquals('SeekableIterator', next($deps));
    }

    public function testDefinedClass()
    {
        $c = new cfhCompile_Class_Reflection($this);
        $this->assertEquals(get_class($this), $c->getName());
        $this->assertEquals(__FILE__, $c->getFileName());
        $this->assertEquals(20, $c->getStartLine());
        $this->assertEquals(112, $c->getEndLine());
        $this->assertFalse($c->isInterface());
        $deps = $c->getDependancys();
        $this->assertTrue(count($deps) == 4);
        $this->assertEquals('PHPUnit_Framework_TestCase', current($deps));
        $this->assertEquals('PHPUnit_Framework_SelfDescribing', next($deps));
        $this->assertEquals('Countable', next($deps));
        $this->assertEquals('PHPUnit_Framework_Test', next($deps));
    }

    public function testEvalClass()
    {
        $mock = $this->getMock('stdClass');
        $c = new cfhCompile_Class_Reflection($mock);
        $this->assertEquals(get_class($mock), $c->getName());
        $this->assertNull($c->getFileName());
        $this->assertNull($c->getStartLine());
        $this->assertNull($c->getEndLine());
        $this->assertFalse($c->isInterface());
        $deps = $c->getDependancys();
        $this->assertTrue(count($deps) == 3);
        $this->assertEquals('stdClass', current($deps));
        $this->assertEquals('PHPUnit_Framework_MockObject_MockObject', next($deps));
        $this->assertEquals('PHPUnit_Framework_MockObject_Verifiable', next($deps));
    }

}