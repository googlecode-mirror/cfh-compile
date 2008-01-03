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
 * @group       cfhCompile_Class
 * @group       cfhCompile_Class_Manual
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
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

    public function testConstructNullStartLineKeepsFileNameNullsEndLine()
    {
        $class = new cfhCompile_Class_Manual(
                                            'name',
                                            'fileName',
                                            NULL,
                                            20
                                            );
        $this->assertEquals('name', $class->getName());
        $this->assertEquals('fileName', $class->getFileName());
        $this->assertNull($class->getStartLine());
        $this->assertNull($class->getEndLine());
    }

    public function testConstructNullEndLineKeepsFileNameNullsStartLine()
    {
        $class = new cfhCompile_Class_Manual(
                                            'name',
                                            'fileName',
                                            10,
                                            NULL
                                            );
        $this->assertEquals('name', $class->getName());
        $this->assertEquals('fileName', $class->getFileName());
        $this->assertNull($class->getStartLine());
        $this->assertNull($class->getEndLine());
    }

    public function testConstructEndLineGreaterThanStartLineNullsLineValues()
    {
        $class = new cfhCompile_Class_Manual(
                                            'name',
                                            'fileName',
                                            20,
                                            10
                                            );
        $this->assertEquals('name', $class->getName());
        $this->assertEquals('fileName', $class->getFileName());
        $this->assertNull($class->getStartLine());
        $this->assertNull($class->getEndLine());
    }

    public function testConstructNegStartLineNullsLinesValues()
    {
        $class = new cfhCompile_Class_Manual(
                                            'name',
                                            'fileName',
                                            -10,
                                            10
                                            );
        $this->assertEquals('name', $class->getName());
        $this->assertEquals('fileName', $class->getFileName());
        $this->assertNull($class->getStartLine());
        $this->assertNull($class->getEndLine());
    }

    public function testConstructNegEndLineNullsLinesValues()
    {
        $class = new cfhCompile_Class_Manual(
                                            'name',
                                            'fileName',
                                            -20,
                                            -10
                                            );
        $this->assertEquals('name', $class->getName());
        $this->assertEquals('fileName', $class->getFileName());
        $this->assertNull($class->getStartLine());
        $this->assertNull($class->getEndLine());
    }

}