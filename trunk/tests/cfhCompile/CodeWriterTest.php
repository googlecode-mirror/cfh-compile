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
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_CodeWriterTest
extends PHPUnit_Framework_TestCase
{

    public function testConstructorDefaults()
    {
        $c  = new cfhCompile_Class_Reflection($this);
        $cw = new cfhCompile_CodeWriter();
        $this->assertType('cfhCompile_CodeWriter_WriteStrategy_Null', $cw->getWriteStrategy());
    }

    public function testGetSetWriter()
    {
        $r  = new cfhCompile_CodeWriter_WriteStrategy_Null();
        $cw = new cfhCompile_CodeWriter();
        $cw->setWriteStrategy($r);
        $this->assertSame($r, $cw->getWriteStrategy());
    }


    public function testAttachDetachPlugin()
    {
        $c  = new cfhCompile_Class_Reflection($this);
        $cr = new cfhCompile_ClassRegistry();
        $cw = new cfhCompile_CodeWriter();
        $p  = $this->getMock('cfhCompile_CodeWriter_Plugin_Abstract');
        $p->expects($this->once())
          ->method('preBegin')
          ->with($this->equalTo($cw))
          ;
        $p->expects($this->once())
          ->method('postBegin')
          ->with($this->equalTo($cw))
          ;
        $p->expects($this->once())
          ->method('preRollback')
          ->with($this->equalTo($cw), $this->equalTo($cr))
          ;
        $p->expects($this->once())
          ->method('postRollback')
          ->with($this->equalTo($cw), $this->equalTo($cr))
          ;
        $p->expects($this->once())
          ->method('preCommit')
          ->with($this->equalTo($cw), $this->equalTo($cr))
          ;
        $p->expects($this->once())
          ->method('postCommit')
          ->with($this->equalTo($cw), $this->equalTo($cr))
          ;
        $p->expects($this->once())
          ->method('preWrite')
          ->with($this->equalTo($cw), $this->equalTo($c), '/* source */', $this->equalTo($cr))
          ->will($this->returnValue('/* source */'))
          ;
        $p->expects($this->once())
          ->method('postWrite')
          ->with($this->equalTo($cw), $this->equalTo($c), '/* source */', $this->equalTo($cr))
          ;
        $p->expects($this->once())
          ->method('preWriteSource')
          ->with($this->equalTo($cw), $this->equalTo('/* source */'))
          ->will($this->returnValue('/* source */'))
          ;
        $p->expects($this->once())
          ->method('postWriteSource')
          ->with($this->equalTo($cw), $this->equalTo('/* source */'))
          ;

        $cw->attachPlugin($p);
        $cw->begin();
        $cw->rollback($cr);
        $cw->commit($cr);
        $cw->write($c, '/* source */', $cr);
        $cw->writeSource('/* source */');

        $cw->detachPlugin($p);
        $cw->begin();
        $cw->rollback($cr);
        $cw->commit($cr);
        $cw->write($c, '/* source */', $cr);
        $cw->writeSource('/* source */');
    }

}