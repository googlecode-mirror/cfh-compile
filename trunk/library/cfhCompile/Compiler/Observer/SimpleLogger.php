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
class cfhCompile_Compiler_Observer_SimpleLogger
implements cfhCompile_Compiler_Observer_Interface
{

    protected $fp;

    public function __construct($fp)
    {
        if(!is_resource($fp) || get_resource_type($fp) != 'stream')
        {
            throw new InvalidArgumentException('Invalid stream resource.');
        }
        $this->fp = $fp;
    }

    /**
     * @param cfhCompile_Compiler_Event $event
     */
    public function notify(cfhCompile_Compiler_Event $event)
    {
        $msg = '';
        switch ($event->getEvent())
        {
            case cfhCompile_Compiler_Event::EVENT_BEGIN:
                $msg .= 'BEGIN ';
                break;
            case cfhCompile_Compiler_Event::EVENT_CLASS:
                $msg .= 'CLASS ';
                break;
            case cfhCompile_Compiler_Event::EVENT_COMMIT:
                $msg .= 'COMMIT ';
                break;
            case cfhCompile_Compiler_Event::EVENT_ROLLBACK:
                $msg .= 'ROLLBACK ';
                break;
            case cfhCompile_Compiler_Event::EVENT_SKIP:
                $msg .= 'SKIP ';
                break;
            case cfhCompile_Compiler_Event::EVENT_NOTFOUND:
                $msg .= 'NOTFOUND ';
                break;
            case cfhCompile_Compiler_Event::EVENT_WRITE:
                $msg .= 'WRITE ';
                break;
        }
        if($event->getClass())
        {
            $msg .= $event->getClass()->getName();
        }
        $msg = trim($msg).PHP_EOL;
        fwrite($this->fp, $msg, strlen($msg));
    }

}