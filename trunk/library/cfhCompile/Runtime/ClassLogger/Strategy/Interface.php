<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Runtime
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Runtime
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
interface cfhCompile_Runtime_ClassLogger_Strategy_Interface
{

    public function begin();

    /**
     * @param cfhCompile_Class_Interface $class
     */
    public function log(cfhCompile_Class_Interface $class);

    public function commit();

    public function rollback();

}