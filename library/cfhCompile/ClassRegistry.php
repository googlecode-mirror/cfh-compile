<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * Global class registry.
 *
 * @category    cfh
 * @package     cfhCompile
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_ClassRegistry
implements IteratorAggregate, Countable
{

    /**
     * @var ArrayObject
     */
    protected $registry;

    public function __construct()
    {
        $this->registry = new ArrayObject(array());
    }

    /**
     * Register a class in the registry
     *
     * @param cfhCompile_Class_Interface $class
     * @return cfhCompile_Class_Interface
     * @throws cfhCompile_ClassRegistry_Exception
     */
    public function register(cfhCompile_Class_Interface $class)
    {
        if(isset($this->registry[$class->getName()]))
        {
            if($this->registry[$class->getName()] === $class)
            {
                return $class;
            }
            throw new cfhCompile_ClassRegistry_Exception(
                      'Class '.$class->getName().' has already been registered.'
                      );
        }
        $this->registry[$class->getName()] = $class;
        return $class;
    }

    /**
     * Fetches a class from the registry.
     * @return cfhCompile_Class_Interface
     */
    public function fetch($className)
    {
        if(!isset($this->registry[$className]))
        {
            return NULL;
        }
        return $this->registry[$className];
    }

    /**
     * Clears out the registry
     */
    public function clear()
    {
        $this->registry->exchangeArray(array());
    }

    /**
     * Returns the current items in the registry.
     * @return ArrayObject
     */
    public function getIterator()
    {
        return $this->registry;
    }

    public function count()
    {
        return $this->registry->count();
    }

}