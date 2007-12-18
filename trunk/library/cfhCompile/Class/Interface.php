<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Class
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Class
 * @copyright   Copyright (c) 2007 William Bailey
 */
interface cfhCompile_Class_Interface
{

    /**
     * Gets the name of the class.
     * @return String
     */
    public function getName();

    /**
     * Gets the name of the file the class is defined in.
     * @return String
     */
    public function getFileName();

    /**
     * Gets the line where the class definition starts
     * @return Integer
     */
    public function getStartLine();

    /**
     * Gets the line where the class definition ends
     * @return Integer
     */
    public function getEndLine();

    /**
     * Gets the class source code.
     * @return String
     */
    public function getSource();

    /**
     * Is the class an Interface
     * @return Boolean
     */
    public function isInterface();

    /**
     * Gets a list of dependancys.
     *
     * This will generally be an array of class/interface names.
     *
     * @return Traversable
     */
    public function getDependancys();

}