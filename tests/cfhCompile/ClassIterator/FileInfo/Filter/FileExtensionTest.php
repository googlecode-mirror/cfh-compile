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
 * @group       cfhCompile_ClassIterator_FileInfo_Filter
 * @group       cfhCompile_ClassIterator_FileInfo_Filter_FileExtension
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_ClassIterator_FileInfo_Filter_FileExtensionTest
extends PHPUnit_Framework_TestCase
{

    public function testAcceptTrue()
    {
        $f = new cfhCompile_ClassIterator_FileInfo_Filter_FileExtension('.php');
        $this->assertTrue($f->accept(new SplFileObject(__FILE__)));
    }

    public function testAcceptFalse()
    {
        $f = new cfhCompile_ClassIterator_FileInfo_Filter_FileExtension('.txt');
        $this->assertFalse($f->accept(new SplFileObject(__FILE__)));
    }

}