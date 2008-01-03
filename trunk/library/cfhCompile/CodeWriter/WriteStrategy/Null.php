<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeWriter
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeWriter
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_CodeWriter_WriteStrategy_Null
implements cfhCompile_CodeWriter_WriteStrategy_Interface
{
    public function begin()
    {
    }

    /**
     * Rollback a code writer process.
     * @param cfhCompile_ClassRegistry $classRegistry
     * @throws cfhCompile_CodeWriter_Exception
     */
    public function rollback(cfhCompile_ClassRegistry $classRegistry)
    {
    }

    /**
     * Commit a code writer process.
     * @param cfhCompile_ClassRegistry $classRegistry
     * @throws cfhCompile_CodeWriter_Exception
     */
    public function commit(cfhCompile_ClassRegistry $classRegistry)
    {
    }

    /**
     * Write a class.
     *
     * @param cfhCompile_Class_Interface $class
     * @param String $sourceCode
     * @param cfhCompile_ClassRegistry $classRegistry
     * @throws cfhCompile_CodeWriter_Exception
     */
    public function write(
                         cfhCompile_Class_Interface $class,
                         $sourceCode,
                         cfhCompile_ClassRegistry $classRegistry
                         )
    {
    }

    /**
     * Writes source code.
     *
     * @param String $sourceCode
     */
    public function writeSource($sourceCode)
    {
    }

}