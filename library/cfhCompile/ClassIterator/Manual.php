<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  ClassIterator
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  ClassIterator
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_ClassIterator_Manual
implements cfhCompile_ClassIterator_Interface
{

    /**
     * @var splObjectStorage
     */
    protected $list;

    public function __construct()
    {
        $this->list = new SplObjectStorage();
    }

    public function current()
    {
        return $this->list->current();
    }

    public function key()
    {
        $c = $this->current();
        if($c instanceof cfhCompile_Class_Interface)
        {
            return $c->getName();
        }
        return NULL;
    }

    public function next()
    {
        $this->list->next();
    }

    public function rewind()
    {
        $this->list->rewind();
    }

    public function valid()
    {
        return $this->list->valid();
    }

    public function attach(cfhCompile_Class_Interface $class)
    {
        $this->list->attach($class);
    }

}