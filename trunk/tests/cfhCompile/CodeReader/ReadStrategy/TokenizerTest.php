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
 * @group       cfhCompile_CodeReader_ReadStrategy
 * @group       cfhCompile_CodeReader_ReadStrategy_Tokenizer
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_CodeReader_ReadStrategy_TokenizerTest
extends PHPUnit_Framework_TestCase
{

    public function testGetSourceCodeIsNullForInternal()
    {
        $c = new cfhCompile_Class_Reflection('stdClass');
        $r = new cfhCompile_CodeReader_ReadStrategy_Tokenizer();
        $this->assertNull($r->getSourceCode($c));
    }

    public function testGetSourceCodeExceptionWhenCantReadFile()
    {
        $c = $this->getMock('cfhCompile_Class_Interface');
        $c->expects($this->any())
          ->method('getFileName')
          ->will($this->returnValue('bad://file'))
          ;
        $r = new cfhCompile_CodeReader_ReadStrategy_Tokenizer();
        try
        {
            $r->getSourceCode($c);
        }
        catch (cfhCompile_CodeReader_Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch cfhCompile_CodeReader_Exception.');
    }

    public function testGetSourceCodeThisClass()
    {
        $c = new cfhCompile_Class_Reflection($this);
        $r = new cfhCompile_CodeReader_ReadStrategy_Tokenizer();

        $code   = @file(__FILE__, FILE_IGNORE_NEW_LINES);
        $offset = $c->getStartLine() - 1;
        $length = $c->getEndLine()   - $offset;
        $code   = trim(implode(PHP_EOL, array_slice($code, $offset, $length)));

        $this->assertEquals($code, $r->getSourceCode($c));
    }

    public function testGetSourceCodeResourceClasses001()
    {
        if(!class_exists('cfhCompile__class001', FALSE)){
            include '.resource/classes.001.php';
        }
        $c = new cfhCompile_Class_Reflection('cfhCompile__interface101');
        $r = new cfhCompile_CodeReader_ReadStrategy_Tokenizer();
        $this->assertEquals('interface cfhCompile__interface101{ function foo(); }', $r->getSourceCode($c));

        $c = new cfhCompile_Class_Reflection('cfhCompile__class101');
        $r = new cfhCompile_CodeReader_ReadStrategy_Tokenizer();
        $this->assertEquals('class cfhCompile__class101{}', $r->getSourceCode($c));

        $c = new cfhCompile_Class_Reflection('cfhCompile__class102');
        $r = new cfhCompile_CodeReader_ReadStrategy_Tokenizer();
        $this->assertEquals('class cfhCompile__class102 extends cfhCompile__class101 implements cfhCompile__interface101 {function foo(){if(TRUE){}else{}}}', $r->getSourceCode($c));

        $c = new cfhCompile_Class_Reflection('cfhCompile__class103');
        $r = new cfhCompile_CodeReader_ReadStrategy_Tokenizer();
        $this->assertEquals('class cfhCompile__class103 {}', $r->getSourceCode($c));
    }

    public function testGetSourceCodeResourceClasses002()
    {
        if(!class_exists('cfhCompile__class201', FALSE)){
            include '.resource/classes.002.php';
        }
        $c = new cfhCompile_Class_Reflection('cfhCompile__class201');
        $r = new cfhCompile_CodeReader_ReadStrategy_Tokenizer();
        $this->assertEquals(
                           'class cfhCompile__class201{'.PHP_EOL
                           .PHP_EOL
                           .'    public function foo()'.PHP_EOL
                           .'    {'.PHP_EOL
                           .PHP_EOL
                           .'    }'.PHP_EOL
                           .PHP_EOL
                           .'}',
                           $r->getSourceCode($c)
                           );
    }

    public function testGetSourceCodeResourceClasses003()
    {
        if(!class_exists('cfhCompile__class301', FALSE)){
            include '.resource/classes.003.php';
        }
        $c = new cfhCompile_Class_Reflection('cfhCompile__class301');
        $r = new cfhCompile_CodeReader_ReadStrategy_Tokenizer();
        $this->assertEquals('final class cfhCompile__class301 {}',$r->getSourceCode($c));

        $c = new cfhCompile_Class_Reflection('cfhCompile__class302');
        $r = new cfhCompile_CodeReader_ReadStrategy_Tokenizer();
        $this->assertEquals('abstract class cfhCompile__class302 {}',$r->getSourceCode($c));
    }

    public function testGetSourceCodeResourceClass301WithNullLineNumbers()
    {
        $c = new cfhCompile_Class_Manual('cfhCompile__class301', realpath(dirname(__FILE__).'/.resource/classes.003.php'));
        $r = new cfhCompile_CodeReader_ReadStrategy_Tokenizer();
        $this->assertEquals('final class cfhCompile__class301 {}',$r->getSourceCode($c));
    }

}