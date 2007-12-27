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
abstract class cfhCompile_CodeWriter_Plugin_Abstract
implements cfhCompile_CodeWriter_Plugin_Interface
{

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     */
    public function preBegin(cfhCompile_CodeWriter $codeWriter)
    {
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     */
    public function postBegin(cfhCompile_CodeWriter $codeWriter)
    {
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function preRollback(
                               cfhCompile_CodeWriter $codeWriter,
                               cfhCompile_ClassRegistry $classRegistry
                               )
    {
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function postRollback(
                                cfhCompile_CodeWriter $codeWriter,
                                cfhCompile_ClassRegistry $classRegistry
                                )
    {
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function preCommit(
                             cfhCompile_CodeWriter $codeWriter,
                             cfhCompile_ClassRegistry $classRegistry
                             )
    {
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function postCommit(
                              cfhCompile_CodeWriter $codeWriter,
                              cfhCompile_ClassRegistry $classRegistry
                              )
    {
    }

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
        return $sourceCode;
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param cfhCompile_Class_Interface $class
     * @param unknown_type $sourceCode
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function postWrite(
                             cfhCompile_CodeWriter $codeWriter,
                             cfhCompile_Class_Interface $class,
                             $sourceCode,
                             cfhCompile_ClassRegistry $classRegistry
                             )
    {
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param unknown_type $sourceCode
     * @return String
     */
    public function preWriteSource(
                                  cfhCompile_CodeWriter $codeWriter,
                                  $sourceCode
                                  )
    {
        return $sourceCode;
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param unknown_type $sourceCode
     */
    public function postWriteSource(
                                   cfhCompile_CodeWriter $codeWriter,
                                   $sourceCode
                                   )
    {
    }

}