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
 * @group       cfhCompile_CodeReader_Plugin
 * @group       cfhCompile_CodeReader_Plugin_Abstract
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_CodeReader_Plugin_AbstractTest
extends PHPUnit_Framework_TestCase
{

    protected $mock;

    public function setUp()
    {
        // we specify a unknown method so that the existing methods are left
        // unmodified in the mocked object.
        $this->mock = $this->getMock('cfhCompile_CodeReader_Plugin_Abstract', array('unknownMethod'));
    }

    public function testPreGetSourceCode()
    {
        $c      = new cfhCompile_Class_Reflection($this);
        $cr     = new cfhCompile_CodeReader();
        $this->assertSame($c, $this->mock->preGetSourceCode($cr, $c));
    }

    public function testPostGetSourceCode()
    {
        $c      = new cfhCompile_Class_Reflection($this);
        $cr     = new cfhCompile_CodeReader();
        $code   = '/* source code */';
        $this->assertSame($code, $this->mock->postGetSourceCode($cr, $c, $code));
    }


}