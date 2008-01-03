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
interface cfhCompile_CodeReader_Plugin_Interface
{

    /**
     * Hook that gets called pre get source code.
     *
     * @param cfhCompile_CodeReader $codeReader
     * @param cfhCompile_Class_Interface $class
     * @return cfhCompile_Class_Interface
     * @throws cfhCompile_CodeReader_Plugin_Exception
     */
    public function preGetSourceCode(
                                     cfhCompile_CodeReader $codeReader,
                                     cfhCompile_Class_Interface $class
                                    );

    /**
     * Hook that gets called post get source code.
     *
     * @param cfhCompile_CodeReader $codeReader
     * @param cfhCompile_Class_Interface $class
     * @param string $sourceCode;
     * @return string The source code to return.
     * @throws cfhCompile_CodeReader_Plugin_Exception
     */
    public function postGetSourceCode(
                                      cfhCompile_CodeReader $codeReader,
                                      cfhCompile_Class_Interface $class,
                                      $sourceCode
                                     );

}