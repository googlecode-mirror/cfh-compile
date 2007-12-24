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
 * @group       cfhCompile_CodeWriter_AtomicStream
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeWriter_AtomicStreamTest
extends PHPUnit_Framework_TestCase
{

    public function testWriteCommit()
    {
        $url  = tempnam(sys_get_temp_dir(), 'cfhCompile');
        file_put_contents($url, '/* before */');
        $this->assertEquals('/* before */', file_get_contents($url));
        $cr = new cfhCompile_ClassRegistry();
        $w  = new cfhCompile_CodeWriter_AtomicStream($url);
        $w->begin();
        $w->write(new cfhCompile_Class_Reflection($this), '/* after */', $cr);
        $w->commit($cr);
        $this->assertTrue(file_exists($url));
        $this->assertEquals('/* after */', file_get_contents($url));
        unlink($url);
    }

    public function testWriteCommitWithThisFile()
    {
        $code = file_get_contents(__FILE__);
        $url  = tempnam(sys_get_temp_dir(), 'cfhCompile');
        $cr   = new cfhCompile_ClassRegistry();
        $w    = new cfhCompile_CodeWriter_AtomicStream($url);
        $w->begin();
        $w->write(new cfhCompile_Class_Reflection($this), $code, $cr);
        $w->commit($cr);
        $this->assertTrue(file_exists($url));
        $this->assertEquals($code, file_get_contents($url));
        unlink($url);
    }

    public function testWriteRollback()
    {
        $url  = tempnam(sys_get_temp_dir(), 'cfhCompile');
        file_put_contents($url, '/* before */');
        $this->assertEquals('/* before */', file_get_contents($url));
        $cr = new cfhCompile_ClassRegistry();
        $w  = new cfhCompile_CodeWriter_AtomicStream($url);
        $w->begin();
        $w->write(new cfhCompile_Class_Reflection($this), '/* after */', $cr);
        $w->rollback($cr);
        $this->assertTrue(file_exists($url));
        $this->assertEquals('/* before */', file_get_contents($url));
        unlink($url);
    }

    public function testInvalidUrlThrowsException()
    {
        $w = new cfhCompile_CodeWriter_AtomicStream('invalid://url');
        try
        {
            $w->begin();
        }
        catch(cfhCompile_CodeWriter_Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch cfhCompile_CodeWriter_Exception.');
    }

    public function testWriteWithoutBeginThrowsException()
    {
        $url = tempnam(sys_get_temp_dir(), 'cfhCompile');
        $w   = new cfhCompile_CodeWriter_AtomicStream($url);
        $cr  = new cfhCompile_ClassRegistry();
        try
        {
            $w->write(new cfhCompile_Class_Reflection($this), '/* test */', $cr);
        }
        catch(cfhCompile_CodeWriter_Exception $e)
        {
            unlink($url);
            return;
        }
        unlink($url);
        $this->fail('Expecting to catch cfhCompile_CodeWriter_Exception.');
    }

    public function testWriteAfterCommitThrowsException()
    {
        $url = tempnam(sys_get_temp_dir(), 'cfhCompile');
        $w   = new cfhCompile_CodeWriter_AtomicStream($url);
        $cr  = new cfhCompile_ClassRegistry();
        $w->begin();
        $w->commit($cr);
        try
        {
            $w->write(new cfhCompile_Class_Reflection($this), '/* test */', $cr);
        }
        catch(cfhCompile_CodeWriter_Exception $e)
        {
            unlink($url);
            return;
        }
        unlink($url);
        $this->fail('Expecting to catch cfhCompile_CodeWriter_Exception.');
    }

    public function testWriteAfterRollbackThrowsException()
    {
        $url = tempnam(sys_get_temp_dir(), 'cfhCompile');
        $w   = new cfhCompile_CodeWriter_AtomicStream($url);
        $cr  = new cfhCompile_ClassRegistry();
        $w->begin();
        $w->rollback($cr);
        try
        {
            $w->write(new cfhCompile_Class_Reflection($this), '/* test */', $cr);
        }
        catch(cfhCompile_CodeWriter_Exception $e)
        {
            unlink($url);
            return;
        }
        unlink($url);
        $this->fail('Expecting to catch cfhCompile_CodeWriter_Exception.');
    }

    public function testRollbackWithoutBeginThrowsException()
    {
        $url = tempnam(sys_get_temp_dir(), 'cfhCompile');
        $w   = new cfhCompile_CodeWriter_AtomicStream($url);
        $cr  = new cfhCompile_ClassRegistry();
        try
        {
            $w->rollback($cr);
        }
        catch(cfhCompile_CodeWriter_Exception $e)
        {
            unlink($url);
            return;
        }
        unlink($url);
        $this->fail('Expecting to catch cfhCompile_CodeWriter_Exception.');
    }

    public function testCommitWithoutBeginThrowsException()
    {
        $url = tempnam(sys_get_temp_dir(), 'cfhCompile');
        $w   = new cfhCompile_CodeWriter_AtomicStream($url);
        $cr  = new cfhCompile_ClassRegistry();
        try
        {
            $w->commit($cr);
        }
        catch(cfhCompile_CodeWriter_Exception $e)
        {
            unlink($url);
            return;
        }
        unlink($url);
        $this->fail('Expecting to catch cfhCompile_CodeWriter_Exception.');
    }

}