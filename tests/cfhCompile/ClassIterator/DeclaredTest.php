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
 * @group       cfhCompile_ClassIterator_Declared
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_ClassIterator_DeclaredTest
extends PHPUnit_Framework_TestCase
{

    public function testIteratorHasCorrectTotal()
    {
        $iterator = new cfhCompile_ClassIterator_Declared();
        $total    = count(get_declared_interfaces())
                  + count(get_declared_classes())
                  ;
        $i        = 0;
        foreach ($iterator as $c)
        {
            $i++;
        }
        $this->assertEquals($total, $i);
    }

    public function testIteratorKeyIsCurrentName()
    {
        $iterator = new cfhCompile_ClassIterator_Declared();
        foreach ($iterator as $k=>$c)
        {
            $this->assertEquals($k, $c->getName());
        }
        $this->assertNull($iterator->key());
        $this->assertNull($iterator->current());
    }

}