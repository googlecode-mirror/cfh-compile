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
 * Provides class information using php reflection.
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Class
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_Class_Reflection
implements cfhCompile_Class_Interface
{

    /**
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * @param String|Object $class
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function __construct($class)
    {
        if(is_object($class))
        {
            $this->reflection = new ReflectionObject($class);
            return;
        }
        if(is_string($class))
        {
            $this->reflection = new ReflectionClass($class);
            return;
        }
        throw new InvalidArgumentException('$class argument invalid.');
    }

    /**
     * Gets the name of the class.
     * @return String
     */
    public function getName()
    {
        return $this->reflection->getName();
    }

    /**
     * Gets the name of the file the class is defined in.
     * @return String
     */
    public function getFileName()
    {
        $f = $this->reflection->getFileName();
        if(!is_readable($f))
        {
            return NULL;
        }
        return $f;
    }

    /**
     * Gets the line where the class definition starts
     * @return Integer
     */
    public function getStartLine()
    {
        $s = $this->reflection->getStartLine();
        if(!$s || !$this->getFileName())
        {
            return NULL;
        }
        return $s;
    }

    /**
     * Gets the line where the class definition ends
     * @return Integer
     */
    public function getEndLine()
    {
        $e = $this->reflection->getEndLine();
        if(!$e || !$this->getFileName())
        {
            return NULL;
        }
        return $e;
    }

    /**
     * Is the class an Interface
     * @return Boolean
     */
    public function isInterface()
    {
        return $this->reflection->isInterface();
    }

    /**
     * Gets a list of dependancys.
     *
     * This will generally be an array of class/interface names.
     *
     * @return Traversable
     */
    public function getDependancys()
    {
        $deps   = array();
        if($this->reflection->getParentClass())
        {
            $deps[] = $this->reflection->getParentClass()->getName();
        }
        foreach($this->reflection->getInterfaces() as $i)
        {
            $deps[] = $i->getName();
        }
        $deps = array_unique($deps);
        return new ArrayObject($deps);
    }

}