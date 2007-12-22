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
class cfhCompile_ClassIterator_Declared
implements cfhCompile_ClassIterator_Interface
{

    /**
     * @var AppendIterator
     */
    protected $list;
    protected $class;

    public function __construct()
    {
        $this->rewind();
    }

    public function current()
    {
        if(!$this->class || $this->class->getName() != $this->list->current())
        {
            if($this->list->current())
            {
                $this->class = new cfhCompile_Class_Reflection($this->list->current());
            }
            else
            {
                $this->class = NULL;
            }
        }
        return $this->class;
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
        $this->list = new AppendIterator();
        $this->list->append(new ArrayIterator(get_declared_interfaces()));
        $this->list->append(new ArrayIterator(get_declared_classes()));
    }

    public function valid()
    {
        return $this->list->valid();
    }

}