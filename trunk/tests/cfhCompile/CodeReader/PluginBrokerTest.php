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
 * @group       cfhCompile_CodeReader_PluginBroker
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_CodeReader_PluginBrokerTest
extends PHPUnit_Framework_TestCase
{

    public function testPreGetSourceCode()
    {
        $c      = new cfhCompile_Class_Reflection($this);
        $cr     = new cfhCompile_CodeReader();
        $plugin = $this->getMock('cfhCompile_CodeReader_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('preGetSourceCode')
               ->with($this->equalTo($cr), $this->equalTo($c))
               ->will($this->returnValue($c))
               ;
        $b = new cfhCompile_CodeReader_PluginBroker();
        $b->attach($plugin);
        $this->assertSame($c, $b->preGetSourceCode($cr, $c));
        $b->detach($plugin);
        $this->assertSame($c, $b->preGetSourceCode($cr, $c));
    }

    public function testPreGetSourceCodeInvalidReturnThrowsException()
    {
        $c      = new cfhCompile_Class_Reflection($this);
        $cr     = new cfhCompile_CodeReader();
        $plugin = $this->getMock('cfhCompile_CodeReader_Plugin_Abstract');
        $plugin->expects($this->any())
               ->method('preGetSourceCode')
               ;
        $b = new cfhCompile_CodeReader_PluginBroker();
        $b->attach($plugin);
        try
        {
            $b->preGetSourceCode($cr, $c);
        }
        catch(cfhCompile_CodeReader_Plugin_Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch cfhCompile_CodeReader_Plugin_Exception.');
    }

    public function testPostGetSourceCode()
    {
        $c      = new cfhCompile_Class_Reflection($this);
        $cr     = new cfhCompile_CodeReader();
        $code   = '/* source code */';
        $plugin = $this->getMock('cfhCompile_CodeReader_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('postGetSourceCode')
               ->with(
                      $this->equalTo($cr),
                      $this->equalTo($c),
                      $this->equalTo($code)
                     )
               ->will($this->returnValue($code))
               ;
        $b = new cfhCompile_CodeReader_PluginBroker();
        $b->attach($plugin);
        $this->assertSame($code, $b->postGetSourceCode($cr, $c, $code));
        $b->detach($plugin);
        $this->assertSame($code, $b->postGetSourceCode($cr, $c, $code));
    }

    public function testPostGetSourceCodeInvalidReturnThrowsException()
    {
        $c      = new cfhCompile_Class_Reflection($this);
        $cr     = new cfhCompile_CodeReader();
        $code   = '/* source code */';
        $plugin = $this->getMock('cfhCompile_CodeReader_Plugin_Abstract');
        $plugin->expects($this->any())
               ->method('postGetSourceCode')
               ->will($this->returnValue(FALSE))
               ;
        $b = new cfhCompile_CodeReader_PluginBroker();
        $b->attach($plugin);
        try
        {
            $b->postGetSourceCode($cr, $c, $code);
        }
        catch(cfhCompile_CodeReader_Plugin_Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch cfhCompile_CodeReader_Plugin_Exception.');
    }

    public function testPostGetSourceCodeEmptySourceStringPassesAndReturnsNull()
    {
        $c      = new cfhCompile_Class_Reflection($this);
        $cr     = new cfhCompile_CodeReader();
        $code   = '    ';
        $plugin = $this->getMock('cfhCompile_CodeReader_Plugin_Abstract');
        $plugin->expects($this->any())
               ->method('postGetSourceCode')
               ->with(
                      $this->equalTo($cr),
                      $this->equalTo($c),
                      $this->equalTo(NULL)
                     )
               ->will($this->returnValue($code))
               ;
        $b = new cfhCompile_CodeReader_PluginBroker();
        $b->attach($plugin);
        $this->assertNull($b->postGetSourceCode($cr, $c, $code));
    }


}