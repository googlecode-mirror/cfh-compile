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
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeReaderTest
extends PHPUnit_Framework_TestCase
{

    public function testConstructorDefaults()
    {
        $c  = new cfhCompile_Class_Reflection($this);
        $cr = new cfhCompile_CodeReader();
        $this->assertType('cfhCompile_CodeReader_ReadStrategy_Null', $cr->getReadStrategy());
        $this->assertNull($cr->getSourceCode($c));
    }

    public function testGetSetReader()
    {
        $r  = new cfhCompile_CodeReader_ReadStrategy_Null();
        $cr = new cfhCompile_CodeReader();
        $cr->setReadStrategy($r);
        $this->assertSame($r, $cr->getReadStrategy());
    }

    public function testGetSourceCodeReturnsReaderSourceValue()
    {
        $source = '/* source code */';
        $r = $this->getMock('cfhCompile_CodeReader_ReadStrategy_Null');
        $r->expects($this->once())
          ->method('getSourceCode')
          ->will($this->returnValue($source));
        $c  = new cfhCompile_Class_Reflection($this);
        $cr = new cfhCompile_CodeReader();
        $cr->setReadStrategy($r);
        $this->assertEquals($source, $cr->getSourceCode($c));
    }

    public function testReaderInvalidSourceCodeThrowsException()
    {
        $r = $this->getMock('cfhCompile_CodeReader_ReadStrategy_Null');
        $r->expects($this->any())
          ->method('getSourceCode')
          ->will($this->returnValue(FALSE));
        $c  = new cfhCompile_Class_Reflection($this);
        $cr = new cfhCompile_CodeReader();
        $cr->setReadStrategy($r);
        try
        {
            $cr->getSourceCode($c);
        }
        catch(cfhCompile_CodeReader_Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch cfhCompile_CodeReader_Exception.');
    }

    public function testAttachDetachPlugin()
    {
        $c  = new cfhCompile_Class_Reflection($this);
        $p  = $this->getMock('cfhCompile_CodeReader_Plugin_Abstract');
        $p->expects($this->once())
          ->method('preGetSourceCode')
          ->will($this->returnValue($c))
          ;
        $p->expects($this->once())
          ->method('postGetSourceCode')
          ->will($this->returnValue(NULL))
          ;
        $cr = new cfhCompile_CodeReader();
        $cr->attachPlugin($p);
        $cr->getSourceCode($c);
        $cr->detachPlugin($p);
        $cr->getSourceCode($c);
    }

}