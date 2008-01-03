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
class cfhCompile_Class_Manual
implements cfhCompile_Class_Interface
{

    protected $name;
    protected $fileName;
    protected $startLine;
    protected $endLine;
    protected $isInterface;
    protected $dependancys;

    public function __construct(
                               $name,
                               $fileName = NULL,
                               $startLine = NULL,
                               $endLine = NULL,
                               $isInterface = FALSE,
                               Traversable $dependancys = NULL
                               )
    {
        $this->name        = trim((string) $name);
        $this->fileName    = trim((string) $fileName);
        $this->startLine   = is_null($startLine) ? NULL : (integer) $startLine;
        $this->endLine     = is_null($endLine)   ? NULL : (integer) $endLine;
        $this->isInterface = (boolean) $isInterface;
        $this->dependancys = $dependancys;
        if(
          $this->fileName == ''
          || is_null($this->fileName)
          )
        {
          $this->fileName  = NULL;
          $this->startLine = NULL;
          $this->endLine   = NULL;
        }
        if(is_null($this->startLine))
        {
            $this->endLine = NULL;
        }
        elseif(is_null($this->endLine))
        {
            $this->startLine = NULL;
        }
        if(!is_null($this->startLine))
        {
            if($this->startLine < 0 || $this->endLine < 0)
            {
                $this->startLine = NULL;
                $this->endLine   = NULL;
            }
            elseif($this->endLine < $this->startLine)
            {
                $this->startLine = NULL;
                $this->endLine   = NULL;
            }
        }
        if(is_null($this->dependancys))
        {
            $this->dependancys = new ArrayIterator(array());
        }
    }

    /**
     * Gets the name of the class.
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the name of the file the class is defined in.
     * @return String
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Gets the line where the class definition starts
     * @return Integer
     */
    public function getStartLine()
    {
        return $this->startLine;
    }

    /**
     * Gets the line where the class definition ends
     * @return Integer
     */
    public function getEndLine()
    {
        return $this->endLine;
    }

    /**
     * Is the class an Interface
     * @return Boolean
     */
    public function isInterface()
    {
        return $this->isInterface;
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
        return $this->dependancys;
    }

}