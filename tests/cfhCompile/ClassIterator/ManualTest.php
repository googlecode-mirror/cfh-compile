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
 * @group       cfhCompile_ClassIterator
 * @group       cfhCompile_ClassIterator_Manual
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_ClassIterator_ManualTest
extends PHPUnit_Framework_TestCase
{

    public function testIteratorInterface()
    {
        $iterator = new cfhCompile_ClassIterator_Manual();
        $iterator->attach(new cfhCompile_Class_Reflection('cfhCompile_ClassIterator_ManualTest'));
        $iterator->attach(new cfhCompile_Class_Reflection('PHPUnit_Framework_TestCase'));
        $iterator->attach(new cfhCompile_Class_Reflection('cfhCompile_ClassIterator_Manual'));
        $iterator->attach(new cfhCompile_Class_Reflection('cfhCompile_Class_Reflection'));
        $iterator->rewind();
        $this->assertTrue($iterator->valid());
        $this->assertEquals('cfhCompile_ClassIterator_ManualTest', $iterator->key());
        $this->assertEquals('cfhCompile_ClassIterator_ManualTest', $iterator->current()->getName());
        $iterator->next();
        $this->assertTrue($iterator->valid());
        $this->assertEquals('PHPUnit_Framework_TestCase', $iterator->key());
        $this->assertEquals('PHPUnit_Framework_TestCase', $iterator->current()->getName());
        $iterator->next();
        $this->assertTrue($iterator->valid());
        $this->assertEquals('cfhCompile_ClassIterator_Manual', $iterator->key());
        $this->assertEquals('cfhCompile_ClassIterator_Manual', $iterator->current()->getName());
        $iterator->next();
        $this->assertTrue($iterator->valid());
        $this->assertEquals('cfhCompile_Class_Reflection', $iterator->key());
        $this->assertEquals('cfhCompile_Class_Reflection', $iterator->current()->getName());
        $iterator->next();
        $this->assertFalse($iterator->valid());
        $this->assertNull($iterator->key());
        $this->assertNull($iterator->current());
    }

}