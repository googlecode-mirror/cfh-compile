<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Runtime
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Runtime
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_Runtime_ClassLogger
{

    /**
     * @var cfhCompile_Runtime_ClassLogger_Strategy_Interface
     */
    protected $logger;

    public function __construct()
    {
        $this->setStrategy(new cfhCompile_Runtime_ClassLogger_Strategy_Null());
    }

    /**
     * @param cfhCompile_Runtime_ClassLogger_Strategy_Interface $logger
     */
    public function setStrategy(cfhCompile_Runtime_ClassLogger_Strategy_Interface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return cfhCompile_Runtime_ClassLogger_Strategy_Interface
     */
    public function getStrategy()
    {
        return $this->logger;
    }

    /**
     * Log the currently defined classes.
     *
     * Generally registered as a shutdown function with
     * the register_shutdown_function() php function.
     */
    public function log()
    {
        try
        {
            $this->logger->begin();
            foreach(new cfhCompile_ClassIterator_Declared() as $class)
            {
                if($class->getFileName())
                {
                    $this->logger->log($class);
                }
            }
            $this->logger->commit();
        }
        catch(Exception $e)
        {
            $this->logger->rollback();
            throw $e;
        }
    }

}