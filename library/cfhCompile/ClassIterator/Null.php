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
class cfhCompile_ClassIterator_Null
implements cfhCompile_ClassIterator_Interface
{

    public function current()
    {
        return NULL;
    }

    public function key()
    {
        return NULL;
    }

    public function next()
    {
    }

    public function rewind()
    {
    }

    public function valid()
    {
        return FALSE;
    }

}