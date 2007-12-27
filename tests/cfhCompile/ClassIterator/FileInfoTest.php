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
 * @group       cfhCompile_ClassIterator
 * @group       cfhCompile_ClassIterator_FileInfo
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_ClassIterator_FileInfoTest
extends PHPUnit_Framework_TestCase
{

    public function testClases001()
    {
        $file = realpath(dirname(__FILE__).'/.resource/classes.001.php');
        $i = new cfhCompile_ClassIterator_FileInfo();
        $i->attach(new SplFileInfo($file)); // duplicate files should only be
        $i->attach(new SplFileInfo($file)); // processed once.
        $i->rewind();

        $this->assertTrue($i->valid());
        $class = $i->current();
        $this->assertEquals($i->key(), $class->getName());
        $this->assertEquals('foo', $class->getName());
        $this->assertEquals($file, $class->getFileName());
        $this->assertEquals(2, $class->getStartLine());
        $this->assertEquals(4, $class->getEndLine());
        $this->assertTrue($class->isInterface());
        $this->assertEquals(0, $class->getDependancys()->count());

        $i->next();
        $this->assertTrue($i->valid());
        $class = $i->current();
        $this->assertEquals($i->key(), $class->getName());
        $this->assertEquals('bar', $class->getName());
        $this->assertEquals($file, $class->getFileName());
        $this->assertEquals(6, $class->getStartLine());
        $this->assertEquals(6, $class->getEndLine());
        $this->assertFalse($class->isInterface());
        $this->assertEquals(0, $class->getDependancys()->count());

        $i->next();
        $this->assertTrue($i->valid());
        $class = $i->current();
        $this->assertEquals($i->key(), $class->getName());
        $this->assertEquals('foobar', $class->getName());
        $this->assertEquals($file, $class->getFileName());
        $this->assertEquals(6, $class->getStartLine());
        $this->assertEquals(6, $class->getEndLine());
        $this->assertFalse($class->isInterface());
        $this->assertEquals(2, $class->getDependancys()->count());
        foreach($class->getDependancys() as $offset => $className)
        {
            if($offset == 0)
            {
                $this->assertEquals('bar', $className);
            }
            else
            {
                $this->assertEquals('foo', $className);
            }
        }

        $i->next();
        $this->assertFalse($i->valid());
        $this->assertNull($i->key());
        $this->assertNull($i->current());
    }

    public function testFilterAccept()
    {
        $file = realpath(dirname(__FILE__).'/.resource/classes.001.php');
        $i = new cfhCompile_ClassIterator_FileInfo();
        $i->attach(new SplFileInfo($file)); // duplicate files should only be
        $i->attachFilter(new cfhCompile_ClassIterator_FileInfo_Filter_FileExtension('.php'));
        $i->rewind();
        $this->assertTrue($i->valid());
    }

    public function testFilterDeny()
    {
        $file = realpath(dirname(__FILE__).'/.resource/classes.001.php');
        $f = new cfhCompile_ClassIterator_FileInfo_Filter_FileExtension('.txt');
        $i = new cfhCompile_ClassIterator_FileInfo();
        $i->attach(new SplFileInfo($file)); // duplicate files should only be
        $i->attachFilter($f);
        $i->rewind();
        $this->assertFalse($i->valid());
        $i->detachFilter($f);
        $i->rewind();
        $this->assertTrue($i->valid());
    }

    public function testRecurseDirectory()
    {
        $this->markTestIncomplete('Test Not implemented.');
    }

}