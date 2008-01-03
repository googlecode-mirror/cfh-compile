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
 * @group       cfhCompile_CodeWriter
 * @group       cfhCompile_CodeWriter_WriteStrategy
 * @group       cfhCompile_CodeWriter_WriteStrategy_Null
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_CodeWriter_WriteStrategy_NullTest
extends PHPUnit_Framework_TestCase
{

    public function testStuff()
    {
        // Its a Null writer it does not do anything
        // so lets just call each method so that its included in the
        // code coverage reports :)
        $cr = new cfhCompile_ClassRegistry();
        $w  = new cfhCompile_CodeWriter_WriteStrategy_Null($url);
        $w->begin();
        $w->write(new cfhCompile_Class_Reflection($this), '/* blah */', $cr);
        $w->writeSource('/* foo */');
        $w->commit($cr);
        $w->rollback($cr);
    }

}