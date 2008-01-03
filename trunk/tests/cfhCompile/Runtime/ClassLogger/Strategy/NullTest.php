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
 * @group       cfhCompile_Runtime
 * @group       cfhCompile_Runtime_ClassLogger_Strategy
 * @group       cfhCompile_Runtime_ClassLogger_Strategy_Null
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_Runtime_ClassLogger_Strategy_NullTest
extends PHPUnit_Framework_TestCase
{

    public function testStuff()
    {
        // Its a Null strategy it does not do anything
        // so lets just call each method so that its included in the
        // code coverage reports :)
        $s = new cfhCompile_Runtime_ClassLogger_Strategy_Null();
        $s->begin();
        $s->log(new cfhCompile_Class_Reflection($this));
        $s->commit();
        $s->rollback();
    }


}