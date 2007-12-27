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
 * @group       cfhCompile_CodeWriter
 * @group       cfhCompile_CodeWriter_PluginBroker
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeWriter_PluginBrokerTest
extends PHPUnit_Framework_TestCase
{

    public function testPreBegin()
    {
        $cw     = new cfhCompile_CodeWriter();
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('preBegin')
               ->with($this->equalTo($cw))
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        $b->preBegin($cw);
        $b->detach($plugin);
        $b->preBegin($cw);
    }

    public function testPostBegin()
    {
        $cw     = new cfhCompile_CodeWriter();
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('postBegin')
               ->with($this->equalTo($cw))
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        $b->postBegin($cw);
        $b->detach($plugin);
        $b->postBegin($cw);
    }

    public function testPreRollback()
    {
        $cr     = new cfhCompile_ClassRegistry();
        $cw     = new cfhCompile_CodeWriter();
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('preRollback')
               ->with($this->equalTo($cw))
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        $b->preRollback($cw, $cr);
        $b->detach($plugin);
        $b->preRollback($cw, $cr);
    }

    public function testPostRollback()
    {
        $cr     = new cfhCompile_ClassRegistry();
        $cw     = new cfhCompile_CodeWriter();
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('postRollback')
               ->with($this->equalTo($cw))
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        $b->postRollback($cw, $cr);
        $b->detach($plugin);
        $b->postRollback($cw, $cr);
    }

    public function testPreCommit()
    {
        $cr     = new cfhCompile_ClassRegistry();
        $cw     = new cfhCompile_CodeWriter();
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('preCommit')
               ->with($this->equalTo($cw))
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        $b->preCommit($cw, $cr);
        $b->detach($plugin);
        $b->preCommit($cw, $cr);
    }

    public function testPostCommit()
    {
        $cr     = new cfhCompile_ClassRegistry();
        $cw     = new cfhCompile_CodeWriter();
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('postCommit')
               ->with($this->equalTo($cw))
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        $b->postCommit($cw, $cr);
        $b->detach($plugin);
        $b->postCommit($cw, $cr);
    }

    public function testPreWrite()
    {
        $c      = '/* source */';
        $cw     = new cfhCompile_CodeWriter();
        $cr     = new cfhCompile_ClassRegistry();
        $cl     = new cfhCompile_Class_Reflection($this);
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('preWrite')
               ->with(
                     $this->equalTo($cw),
                     $this->equalTo($cl),
                     $this->equalTo($c),
                     $this->equalTo($cr)
                     )
               ->will($this->returnValue('/* code */'))
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        $this->assertEquals('/* code */', $b->preWrite($cw, $cl, $c, $cr));
        $b->detach($plugin);
        $this->assertEquals($c, $b->preWrite($cw, $cl, $c, $cr));
    }

    public function testPreWriteEmptySourceIsNull()
    {
        $c      = '   ';
        $cw     = new cfhCompile_CodeWriter();
        $cr     = new cfhCompile_ClassRegistry();
        $cl     = new cfhCompile_Class_Reflection($this);
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('preWrite')
               ->with(
                     $this->equalTo($cw),
                     $this->equalTo($cl),
                     $this->equalTo(NULL),
                     $this->equalTo($cr)
                     )
               ->will($this->returnValue(NULL))
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        $this->assertNull($b->preWrite($cw, $cl, $c, $cr));
        $b->detach($plugin);
        $this->assertNull($b->preWrite($cw, $cl, $c, $cr));
    }

    public function testPreWriteInvalidReturnThrowsException()
    {
        $c      = '   ';
        $cw     = new cfhCompile_CodeWriter();
        $cr     = new cfhCompile_ClassRegistry();
        $cl     = new cfhCompile_Class_Reflection($this);
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('preWrite')
               ->will($this->returnValue($this))
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        try
        {
            $b->preWrite($cw, $cl, $c, $cr);
        }
        catch(cfhCompile_CodeWriter_Plugin_Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch cfhCompile_CodeWriter_Plugin_Exception.');
    }

    public function testPostWrite()
    {
        $c      = '/* source */';
        $cw     = new cfhCompile_CodeWriter();
        $cr     = new cfhCompile_ClassRegistry();
        $cl     = new cfhCompile_Class_Reflection($this);
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('postWrite')
               ->with(
                     $this->equalTo($cw),
                     $this->equalTo($cl),
                     $this->equalTo($c),
                     $this->equalTo($cr)
                     )
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        $b->postWrite($cw, $cl, $c, $cr);
        $b->detach($plugin);
        $b->postWrite($cw, $cl, $c, $cr);
    }

    public function testPreWriteSource()
    {
        $c      = '/* source */';
        $cw     = new cfhCompile_CodeWriter();
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('preWriteSource')
               ->with($this->equalTo($cw), $this->equalTo($c))
               ->will($this->returnValue('/* code */'))
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        $this->assertEquals('/* code */', $b->preWriteSource($cw, $c));
        $b->detach($plugin);
        $this->assertEquals($c, $b->preWriteSource($cw, $c));
    }

    public function testPreWriteSourceEmptySourceIsNull()
    {
        $c      = '   ';
        $cw     = new cfhCompile_CodeWriter();
        $cr     = new cfhCompile_ClassRegistry();
        $cl     = new cfhCompile_Class_Reflection($this);
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('preWriteSource')
               ->with(
                     $this->equalTo($cw),
                     $this->equalTo(NULL)
                     )
               ->will($this->returnValue(NULL))
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        $this->assertNull($b->preWriteSource($cw, $c));
        $b->detach($plugin);
        $this->assertNull($b->preWriteSource($cw, $c));
    }

    public function testPreWriteSourceInvalidReturnThrowsException()
    {
        $c      = '   ';
        $cw     = new cfhCompile_CodeWriter();
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('preWriteSource')
               ->will($this->returnValue($this))
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        try
        {
            $b->preWriteSource($cw, $c);
        }
        catch(cfhCompile_CodeWriter_Plugin_Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch cfhCompile_CodeWriter_Plugin_Exception.');
    }

    public function testPostWriteSource()
    {
        $c      = '/* source */';
        $cw     = new cfhCompile_CodeWriter();
        $plugin = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $plugin->expects($this->once())
               ->method('postWriteSource')
               ->with(
                     $this->equalTo($cw),
                     $this->equalTo($c)
                     )
               ;
        $b = new cfhCompile_CodeWriter_PluginBroker();
        $b->attach($plugin);
        $b->postWriteSource($cw, $c);
        $b->detach($plugin);
        $b->postWriteSource($cw, $c);
    }

}