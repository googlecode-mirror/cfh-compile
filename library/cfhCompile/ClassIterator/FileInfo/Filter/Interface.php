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
interface cfhCompile_ClassIterator_FileInfo_Filter_Interface
{

    /**
     * Should the file object be accepted.
     *
     * @param splFileInfo $file
     * @return Boolean
     */
    public function accept(splFileInfo $file);

}