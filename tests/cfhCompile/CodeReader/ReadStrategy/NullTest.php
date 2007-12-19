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
 * @group       cfhCompile_CodeReader
 * @group       cfhCompile_CodeReader_ReadStrategy
 * @group       cfhCompile_CodeReader_ReadStrategy_Null
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeReader_ReadStrategy_NullTest
extends PHPUnit_Framework_TestCase
{

    public function testGetSourceCode()
    {
        $c = new cfhCompile_Class_Reflection($this);
        $r = new cfhCompile_CodeReader_ReadStrategy_Null();
        $this->assertNull($r->getSourceCode($c));
    }

}