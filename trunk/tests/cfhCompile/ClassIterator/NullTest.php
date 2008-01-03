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
 * @group       cfhCompile_ClassIterator
 * @group       cfhCompile_ClassIterator_Null
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_ClassIterator_NullTest
extends PHPUnit_Framework_TestCase
{

    public function testIteratorIsEmpty()
    {
        $iterator = new cfhCompile_ClassIterator_Null();
        $i        = 0;
        foreach ($iterator as $c)
        {
            $i++;
        }
        $this->assertEquals(0, $i);
    }

    public function testCurrentAndKeyAreNull()
    {
        $iterator = new cfhCompile_ClassIterator_Null();
        $this->assertNull($iterator->key());
        $this->assertNull($iterator->current());
        $iterator->next();
        $this->assertNull($iterator->key());
        $this->assertNull($iterator->current());
    }

    public function testValidIsFalse()
    {
        $iterator = new cfhCompile_ClassIterator_Null();
        $this->assertFalse($iterator->valid());
        $iterator->rewind();
        $this->assertFalse($iterator->valid());
        $iterator->next();
        $this->assertFalse($iterator->valid());
    }

}