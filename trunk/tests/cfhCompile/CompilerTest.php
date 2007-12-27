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
 * @group       cfhCompile_Compiler
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CompilerTest
extends PHPUnit_Framework_TestCase
{

    public function testInvalidCodeReaderThrowsException()
    {
        $c = new cfhCompile_Compiler();
        try
        {
            $c->compile();
        }
        catch(cfhCompile_Compiler_Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch cfhCompile_Compiler_Exception.');
    }

    public function testInvalidCodeWriterThrowsException()
    {
        $c = new cfhCompile_Compiler();
        $c->setCodeReader(new cfhCompile_CodeReader());
        try
        {
            $c->compile();
        }
        catch(cfhCompile_Compiler_Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch cfhCompile_Compiler_Exception.');
    }

    public function testClassRegistryClearGetCalledTwiceInCompile()
    {
        $r = $this->getMock('cfhCompile_ClassRegistry', array('clear'));
        $r->expects($this->exactly(2))
          ->method('clear')
          ;
        $c = new cfhCompile_Compiler();
        $c->setClassRegistry($r);
        $c->setCodeReader(new cfhCompile_CodeReader());
        $c->setCodeWriter($this->getMock('cfhCompile_CodeWriter_WriteStrategy_Interface'));
        $c->compile();
    }

    public function testClassRegistryClearGetCalledTwiceInCompileWithException()
    {
        $r = $this->getMock('cfhCompile_ClassRegistry');
        $r->expects($this->exactly(2))
          ->method('clear')
          ;
        $w = $this->getMock('cfhCompile_CodeWriter_WriteStrategy_Interface');
        $w->expects($this->once())
          ->method('begin')
          ->will($this->throwException(new cfhCompile_CodeWriter_Exception))
          ;
        $c = new cfhCompile_Compiler();
        $c->setClassRegistry($r);
        $c->setCodeReader(new cfhCompile_CodeReader());
        $c->setCodeWriter($w);
        try {
            $c->compile();
        }
        catch(cfhCompile_CodeWriter_Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch cfhCompile_CodeWriter_Exception.');
    }

    public function testCodeWriterNotCalledIfSourceIsNull()
    {
        $r = new cfhCompile_CodeReader();
        $r->setReadStrategy(new cfhCompile_CodeReader_ReadStrategy_Null());
        $w = $this->getMock('cfhCompile_CodeWriter_WriteStrategy_Interface');
        $w->expects($this->once())
          ->method('begin')
          ;
        $w->expects($this->never())
          ->method('write')
          ;
        $w->expects($this->once())
          ->method('commit')
          ;
        $i = new cfhCompile_ClassIterator_Manual();
        $i->attach(new cfhCompile_Class_Reflection($this));
        $c = new cfhCompile_Compiler();
        $c->setCodeReader($r);
        $c->setCodeWriter($w);
        $c->setClassIterator($i);
        $c->compile();
    }

    public function testCodeWriterCalledIfSourceNotNull()
    {
        $class = new cfhCompile_Class_Reflection($this);
        $cr = new cfhCompile_ClassRegistry();

        $w = $this->getMock('cfhCompile_CodeWriter_WriteStrategy_Interface');
        $w->expects($this->once())
          ->method('begin')
          ;
        $w->expects($this->once())
          ->method('write')
          ->with(
                $this->equalTo($class),
                $this->equalTo('/* source code */'),
                $this->equalTo($cr)
                )
          ;
        $w->expects($this->once())
          ->method('commit')
          ;

        $rs = $this->getMock('cfhCompile_CodeReader_ReadStrategy_Interface');
        $rs->expects($this->once())
           ->method('getSourceCode')
           ->will($this->returnValue('/* source code */'))
           ;

        $r = new cfhCompile_CodeReader();
        $r->setReadStrategy($rs);

        $i = new cfhCompile_ClassIterator_Manual();
        $i->attach($class);

        $c = new cfhCompile_Compiler();
        $c->setCodeReader($r);
        $c->setCodeWriter($w);
        $c->setClassIterator($i);
        $c->setClassRegistry($cr);
        $c->compile();
    }

    public function testObserver()
    {
        $o = $this->getMock('cfhCompile_Compiler_Observer_Interface');
        $o->expects($this->exactly(4)) // BEGIN, CLASS, SKIP, COMMIT
          ->method('notify')
          ;
        $i = new cfhCompile_ClassIterator_Manual();
        $i->attach(new cfhCompile_Class_Reflection($this));

        $c = new cfhCompile_Compiler();
        $c->setCodeReader(new cfhCompile_CodeReader());
        $c->setCodeWriter($this->getMock('cfhCompile_CodeWriter_WriteStrategy_Interface'));
        $c->setClassIterator($i);
        $c->attachObserver($o);
        $c->attachObserver($o);
        $c->attachObserver($o);
        $c->compile();
        $c->detachObserver($o);
        $c->compile();
    }

    public function testDuplicateClassNameThrowsException()
    {
        $i = new cfhCompile_ClassIterator_Manual();
        $i->attach(new cfhCompile_Class_Reflection($this));
        $i->attach(new cfhCompile_Class_Reflection($this));
        $c = new cfhCompile_Compiler();
        $c->setCodeReader(new cfhCompile_CodeReader());
        $c->setCodeWriter($this->getMock('cfhCompile_CodeWriter_WriteStrategy_Interface'));
        $c->setClassIterator($i);
        try {
            $c->compile();
        }
        catch(cfhCompile_ClassRegistry_Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch cfhCompile_ClassRegistry_Exception.');
    }

}