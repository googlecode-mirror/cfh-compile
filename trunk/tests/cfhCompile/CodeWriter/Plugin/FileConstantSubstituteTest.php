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
 * @group       cfhCompile_CodeWriter_Plugin_FileConstantSubstitute
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeWriter_Plugin_FileConstantSubstituteTest
extends PHPUnit_Framework_TestCase
{

    public function testPreWrite()
    {
        $p      = new cfhCompile_CodeWriter_Plugin_FileConstantSubstitute();
        $c      = new cfhCompile_Class_Manual('foo', '/path/to/foo.php', 1, 7);
        $cw     = new cfhCompile_CodeWriter();
        $cr     = new cfhCompile_ClassRegistry();
        $code   = array();
        $code[] = 'class foo {';
        $code[] = '';
        $code[] = '    function bar() {';
        $code[] = '        return "__FILE__ is ".__FILE__.PHP_EOL;';
        $code[] = '    }';
        $code[] = '';
        $code[] = '}';
        $code   = trim(implode("\n", $code));
        $expectCode   = array();
        $expectCode[] = 'class foo {';
        $expectCode[] = '';
        $expectCode[] = '    function bar() {';
        $expectCode[] = '        return "__FILE__ is ".\'/path/to/foo.php\'.PHP_EOL;';
        $expectCode[] = '    }';
        $expectCode[] = '';
        $expectCode[] = '}';
        $expectCode   = trim(implode("\n", $expectCode));
        $this->assertEquals($expectCode, $p->preWrite($cw, $c, $code, $cr));
    }

    public function testPreWriteNull()
    {
        $p  = new cfhCompile_CodeWriter_Plugin_FileConstantSubstitute();
        $c  = new cfhCompile_Class_Manual('foo', '/path/to/foo.php', 1, 7);
        $cw = new cfhCompile_CodeWriter();
        $cr = new cfhCompile_ClassRegistry();
        $this->assertNull($p->preWrite($cw, $c, NULL, $cr));
    }

}