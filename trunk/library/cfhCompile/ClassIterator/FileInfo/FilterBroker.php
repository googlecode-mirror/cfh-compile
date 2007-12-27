<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  ClassIterator
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  ClassIterator
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_ClassIterator_FileInfo_FilterBroker
implements cfhCompile_ClassIterator_FileInfo_Filter_Interface
{

    /**
     * @var SplObjectStorage
     */
    protected $filters;

    public function __construct()
    {
        $this->filters = new SplObjectStorage();
    }

    public function attach(cfhCompile_ClassIterator_FileInfo_Filter_Interface $filter)
    {
        $this->filters->attach($filter);
    }

    public function detach(cfhCompile_ClassIterator_FileInfo_Filter_Interface $filter)
    {
        $this->filters->detach($filter);
    }

    /**
     * Should the file object be accepted.
     *
     * @param splFileInfo $file
     * @return Boolean
     */
    public function accept(splFileInfo $file)
    {
        foreach ($this->filters as $filter)
        {
            if($filter->accept($file) !== TRUE)
            {
                return FALSE;
            }
        }
        return TRUE;
    }

}