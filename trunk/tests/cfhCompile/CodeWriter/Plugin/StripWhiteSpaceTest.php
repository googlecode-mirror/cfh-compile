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
 * @group       cfhCompile_CodeReader
 * @group       cfhCompile_CodeWriter_Plugin
 * @group       cfhCompile_CodeWriter_Plugin_StripWhiteSpace
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_CodeWriter_Plugin_StripWhiteSpaceTest
extends PHPUnit_Framework_TestCase
{

    public function testPreWrite()
    {
        $p      = new cfhCompile_CodeWriter_Plugin_StripWhiteSpace();
        $c      = new cfhCompile_Class_Manual('foo', '/path/to/foo.php', 1, 7);
        $cw     = new cfhCompile_CodeWriter();
        $cr     = new cfhCompile_ClassRegistry();
        $code   = array();
        $code[] = 'class foo {';
        $code[] = '';
        $code[] = '    function bar( foo &$ref, foo $foo = NULL, $bool = FALSE ) {';
        $code[] = '        return "foo" . ($bool ? $ref : $foo)';
        $code[] = '    }';
        $code[] = '';
        $code[] = '}';
        $code   = implode(PHP_EOL, $code);
        $expect = 'class foo{function bar(foo&$ref,foo $foo=NULL,$bool=FALSE){return "foo".($bool?$ref:$foo)}}';
        $this->assertEquals($expect, $p->preWrite($cw, $c, $code, $cr));
    }

    public function testPreWriteNull()
    {
        $p  = new cfhCompile_CodeWriter_Plugin_StripWhiteSpace();
        $c  = new cfhCompile_Class_Manual('foo', '/path/to/foo.php', 1, 7);
        $cw = new cfhCompile_CodeWriter();
        $cr = new cfhCompile_ClassRegistry();
        $this->assertNull($p->preWrite($cw, $c, NULL, $cr));
    }

}