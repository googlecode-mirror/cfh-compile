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
 * @group       cfhCompile_CodeReader_Plugin
 * @group       cfhCompile_CodeReader_Plugin_StripWhiteSpace
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeReader_Plugin_StripWhiteSpaceTest
extends PHPUnit_Framework_TestCase
{

    public function testPostGetSourceCode()
    {
        $p      = new cfhCompile_CodeReader_Plugin_StripWhiteSpace();
        $c      = new cfhCompile_Class_Manual('foo', '/path/to/foo.php', 1, 7);
        $cr     = new cfhCompile_CodeReader();
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
        $this->assertEquals($expect, $p->postGetSourceCode($cr, $c, $code));
    }

    public function testPostGetSourceCodeNull()
    {
        $p  = new cfhCompile_CodeReader_Plugin_StripWhiteSpace();
        $c  = new cfhCompile_Class_Manual('foo', '/path/to/foo.php', 1, 7);
        $cr = new cfhCompile_CodeReader();
        $this->assertNull($p->postGetSourceCode($cr, $c, NULL));
    }

}