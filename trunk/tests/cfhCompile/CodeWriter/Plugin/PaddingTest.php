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
 * @group       cfhCompile_CodeWriter_Plugin
 * @group       cfhCompile_CodeWriter_Plugin_StripWhiteSpace
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeWriter_Plugin_PaddingTest
extends PHPUnit_Framework_TestCase
{

    public function testPreWrite()
    {
        $p      = new cfhCompile_CodeWriter_Plugin_Padding();
        $c      = new cfhCompile_Class_Manual('foo', '/path/to/foo.php', 1, 7);
        $cw     = new cfhCompile_CodeWriter();
        $cr     = new cfhCompile_ClassRegistry();
        $code   = '/* code */';
        $expect = PHP_EOL.$code.PHP_EOL;
        $this->assertEquals($expect, $p->preWrite($cw, $c, $code, $cr));
    }

    public function testPreWriteNull()
    {
        $p  = new cfhCompile_CodeWriter_Plugin_Padding();
        $c  = new cfhCompile_Class_Manual('foo', '/path/to/foo.php', 1, 7);
        $cw = new cfhCompile_CodeWriter();
        $cr = new cfhCompile_ClassRegistry();
        $this->assertNull($p->preWrite($cw, $c, NULL, $cr));
    }

}