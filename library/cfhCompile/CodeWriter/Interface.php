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
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeWriter
 * @copyright   Copyright (c) 2007 William Bailey
 */
interface cfhCompile_CodeWriter_Interface
{

    /**
     * Begin a code writer process.
     */
    public function begin();

    /**
     * Rollback a code writer process.
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function rollback(cfhCompile_ClassRegistry $classRegistry);

    /**
     * Commit a code writer process.
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function commit(cfhCompile_ClassRegistry $classRegistry);

    /**
     * Write a class.
     *
     * @param cfhCompile_Class_Interface $class
     * @param String $sourceCode
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function write(
                         cfhCompile_Class_Interface $class,
                         $sourceCode,
                         cfhCompile_ClassRegistry $classRegistry
                         );

}