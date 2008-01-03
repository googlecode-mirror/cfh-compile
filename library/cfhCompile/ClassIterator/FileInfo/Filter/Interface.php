<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  ClassIterator
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  ClassIterator
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
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