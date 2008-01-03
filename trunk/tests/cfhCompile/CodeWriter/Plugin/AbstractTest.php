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
 * @group       cfhCompile_CodeWriter_Plugin
 * @group       cfhCompile_CodeWriter_Plugin_Abstract
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_CodeWriter_Plugin_AbstractTest
extends PHPUnit_Framework_TestCase
{

    protected $mock;

    public function setUp()
    {
        // we specify a unknown method so that the existing methods are left
        // unmodified in the mocked object.
        $this->mock = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract', array('unknownMethod'));
    }

    public function testPreBegin()
    {
        $cw = new cfhCompile_CodeWriter();
        $this->assertNull($this->mock->preBegin($cw));
    }

    public function testPostBegin()
    {
        $cw = new cfhCompile_CodeWriter();
        $this->assertNull($this->mock->postBegin($cw));
    }

    public function testPreRollback()
    {
        $cr = new cfhCompile_ClassRegistry();
        $cw = new cfhCompile_CodeWriter();
        $this->assertNull($this->mock->preRollback($cw, $cr));
    }

    public function testPostRollback()
    {
        $cr = new cfhCompile_ClassRegistry();
        $cw = new cfhCompile_CodeWriter();
        $this->assertNull($this->mock->postRollback($cw, $cr));
    }

    public function testPreCommit()
    {
        $cr = new cfhCompile_ClassRegistry();
        $cw = new cfhCompile_CodeWriter();
        $this->assertNull($this->mock->preCommit($cw, $cr));
    }

    public function testPostCommit()
    {
        $cr = new cfhCompile_ClassRegistry();
        $cw = new cfhCompile_CodeWriter();
        $this->assertNull($this->mock->postCommit($cw, $cr));
    }

    public function testPreWrite()
    {
        $cl = new cfhCompile_Class_Reflection($this);
        $co = '/* source */';
        $cr = new cfhCompile_ClassRegistry();
        $cw = new cfhCompile_CodeWriter();
        $this->assertEquals($co, $this->mock->preWrite($cw, $cl, $co, $cr));
    }

    public function testPostWrite()
    {
        $cl = new cfhCompile_Class_Reflection($this);
        $co = '/* source */';
        $cr = new cfhCompile_ClassRegistry();
        $cw = new cfhCompile_CodeWriter();
        $this->assertNull($this->mock->postWrite($cw, $cl, $co, $cr));
    }

    public function testPreWriteSource()
    {
        $co = '/* source */';
        $cw = new cfhCompile_CodeWriter();
        $this->assertEquals($co, $this->mock->preWriteSource($cw, $co));
    }

    public function testPostWriteSource()
    {
        $co = '/* source */';
        $cw = new cfhCompile_CodeWriter();
        $this->assertNull($this->mock->postWriteSource($cw, $co));
    }


}