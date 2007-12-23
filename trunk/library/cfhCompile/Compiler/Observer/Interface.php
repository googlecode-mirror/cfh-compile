<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Compiler
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Compiler
 * @copyright   Copyright (c) 2007 William Bailey
 */
interface cfhCompile_Compiler_Observer_Interface
{

    /**
     * @param cfhCompile_Compiler_Event $event
     */
    public function notify(cfhCompile_Compiler_Event $event);

}