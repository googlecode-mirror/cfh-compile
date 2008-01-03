<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeReader
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeReader
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_CodeReader_ReadStrategy_Null
implements cfhCompile_CodeReader_ReadStrategy_Interface
{

    /**
     * Gets the source code for the specified class.
     *
     * @param cfhCompile_Class_Interface $class
     * @return String
     */
    public function getSourceCode(cfhCompile_Class_Interface $class)
    {
        return NULL;
    }

}