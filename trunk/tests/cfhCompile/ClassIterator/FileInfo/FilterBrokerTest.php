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
 * @group       cfhCompile_ClassIterator_FileInfo_FilterBroker
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_ClassIterator_FileInfo_FilterBrokerTest
extends PHPUnit_Framework_TestCase
implements cfhCompile_ClassIterator_FileInfo_Filter_Interface
{

    protected $acceptReturn = FALSE;

    public function testConstruct()
    {
        $fb = new cfhCompile_ClassIterator_FileInfo_FilterBroker();
        $this->assertTrue($fb->accept(new SplFileInfo(__FILE__)));
    }

    public function testFalseFilter()
    {
        $file = new SplFileInfo(__FILE__);
        $fb   = new cfhCompile_ClassIterator_FileInfo_FilterBroker();
        $fb->attach($this);
        $this->acceptReturn = FALSE;
        $this->assertFalse($fb->accept($file));
        $fb->detach($this);
        $this->assertTrue($fb->accept($file));
    }

    public function testTrueFilter()
    {
        $file = new SplFileInfo(__FILE__);
        $fb   = new cfhCompile_ClassIterator_FileInfo_FilterBroker();
        $fb->attach($this);
        $this->acceptReturn = TRUE;
        $this->assertTrue($fb->accept($file));
    }

    /**
     * Should the file object be accepted.
     *
     * @param splFileInfo $file
     * @return Boolean
     */
    public function accept(splFileInfo $file)
    {
        return $this->acceptReturn;
    }

}