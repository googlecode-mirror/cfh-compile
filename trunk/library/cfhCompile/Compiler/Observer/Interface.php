<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Compiler
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Compiler
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
interface cfhCompile_Compiler_Observer_Interface
{

    /**
     * @param cfhCompile_Compiler_Event $event
     */
    public function notify(cfhCompile_Compiler_Event $event);

}