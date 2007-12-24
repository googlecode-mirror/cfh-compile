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
 * @group       cfhCompile_Class_Manual
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_Class_ManualTest
extends PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $deps = new ArrayObject(array('foo', 'bar'));
        $class = new cfhCompile_Class_Manual(
                                            'name',
                                            'fileName',
                                            10,
                                            20,
                                            TRUE,
                                            $deps
                                            );
        $this->assertEquals('name', $class->getName());
        $this->assertEquals('fileName', $class->getFileName());
        $this->assertEquals(10, $class->getStartLine());
        $this->assertEquals(20, $class->getEndLine());
        $this->assertTrue($class->isInterface());
        $this->assertSame($deps, $class->getDependancys());
    }

    public function testConstructNullFileNameNullsLines()
    {
        $class = new cfhCompile_Class_Manual(
                                            'name',
                                            NULL,
                                            10,
                                            20
                                            );
        $this->assertEquals('name', $class->getName());
        $this->assertNull($class->getFileName());
        $this->assertNull($class->getStartLine());
        $this->assertNull($class->getEndLine());
    }

    public function testConstructNullStartLineNullsFileNameAndEndLine()
    {
        $class = new cfhCompile_Class_Manual(
                                            'name',
                                            'fileName',
                                            NULL,
                                            20
                                            );
        $this->assertEquals('name', $class->getName());
        $this->assertNull($class->getFileName());
        $this->assertNull($class->getStartLine());
        $this->assertNull($class->getEndLine());
    }

    public function testConstructNullEndLineNullsFileNameAndStartLine()
    {
        $class = new cfhCompile_Class_Manual(
                                            'name',
                                            'fileName',
                                            10,
                                            NULL
                                            );
        $this->assertEquals('name', $class->getName());
        $this->assertNull($class->getFileName());
        $this->assertNull($class->getStartLine());
        $this->assertNull($class->getEndLine());
    }

    public function testConstructEndLineGreaterThanStartLineNullsValues()
    {
        $class = new cfhCompile_Class_Manual(
                                            'name',
                                            'fileName',
                                            20,
                                            10
                                            );
        $this->assertEquals('name', $class->getName());
        $this->assertNull($class->getFileName());
        $this->assertNull($class->getStartLine());
        $this->assertNull($class->getEndLine());
    }

    public function testConstructNegStartLineNullsValues()
    {
        $class = new cfhCompile_Class_Manual(
                                            'name',
                                            'fileName',
                                            -10,
                                            10
                                            );
        $this->assertEquals('name', $class->getName());
        $this->assertNull($class->getFileName());
        $this->assertNull($class->getStartLine());
        $this->assertNull($class->getEndLine());
    }

    public function testConstructNegEndLineNullsValues()
    {
        $class = new cfhCompile_Class_Manual(
                                            'name',
                                            'fileName',
                                            -20,
                                            -10
                                            );
        $this->assertEquals('name', $class->getName());
        $this->assertNull($class->getFileName());
        $this->assertNull($class->getStartLine());
        $this->assertNull($class->getEndLine());
    }

}