<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeWriter
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * Strip all comments from the source code.
 *
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeWriter
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeWriter_Plugin_Padding
extends cfhCompile_CodeWriter_Plugin_Abstract
{

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param cfhCompile_Class_Interface $class
     * @param unknown_type $sourceCode
     * @param cfhCompile_ClassRegistry $classRegistry
     * @return String
     */
    public function preWrite(
                            cfhCompile_CodeWriter $codeWriter,
                            cfhCompile_Class_Interface $class,
                            $sourceCode,
                            cfhCompile_ClassRegistry $classRegistry
                            )
    {

        if(is_null($sourceCode))
        {
            return NULL;
        }
        return PHP_EOL.$sourceCode.PHP_EOL;
    }
}