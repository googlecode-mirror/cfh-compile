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
class cfhCompile_Compiler
{

    /**
     * @var cfhCompile_ClassIterator_Interface
     */
    protected $classIterator;
    /**
     * @var cfhCompile_CodeReader_ReadStrategy_Interface
     */
    protected $codeReader;
    /**
     * @var cfhCompile_CodeWriter_WriteStrategy_Interface
     */
    protected $codeWriter;
    /**
     * @var cfhCompile_ClassRegistry
     */
    protected $classRegistry;

    /**
     * @var splObjectStorage
     */
    protected $observers;

    /**
     * @var array
     */
    protected $classesWritten = array();
    /**
     * @var array
     */
    protected $classChildren = array();


    public function __construct()
    {
        $this->classIterator = new cfhCompile_ClassIterator_Null();
        $this->classRegistry = new cfhCompile_ClassRegistry();
        $this->observers     = new SplObjectStorage();
    }

    public function attachObserver(cfhCompile_Compiler_Observer_Interface $observer)
    {
        $this->observers->attach($observer);
    }

    public function detachObserver(cfhCompile_Compiler_Observer_Interface $observer)
    {
        $this->observers->detach($observer);
    }

    public function setClassIterator(cfhCompile_ClassIterator_Interface $iterator)
    {
        $this->classIterator = $iterator;
    }

    public function setClassRegistry(cfhCompile_ClassRegistry $registry)
    {
        $this->classRegistry = $registry;
    }

    public function setCodeReader(cfhCompile_CodeReader_ReadStrategy_Interface $r)
    {
        $this->codeReader = $r;
    }

    public function setCodeWriter(cfhCompile_CodeWriter_WriteStrategy_Interface $w)
    {
        $this->codeWriter = $w;
    }

    /**
     * 'Compiles'
     * @throws cfhCompile_Compiler_Exception
     * @throws cfhCompile_ClassRegistry_Exception
     * @throws cfhCompile_CodeWriter_Exception
     */
    public function compile()
    {
        if(!$this->codeReader instanceof cfhCompile_CodeReader_ReadStrategy_Interface)
        {
            throw new cfhCompile_Compiler_Exception('Invalid or undefined code reader.');
        }
        if(!$this->codeWriter instanceof cfhCompile_CodeWriter_WriteStrategy_Interface)
        {
            throw new cfhCompile_Compiler_Exception('Invalid or undefined code writer.');
        }
        try
        {
            $this->classChildren  = array();
            $this->classesWritten = array();
            $this->classRegistry->clear();
            $this->notify(cfhCompile_Compiler_Event::EVENT_BEGIN);
            $this->codeWriter->begin();
            foreach ($this->classIterator as $class)
            {
                $this->classRegistry->register($class);
                $this->notify(cfhCompile_Compiler_Event::EVENT_CLASS, $class);
                $this->checkDependancysAndWrite($class);
            }
            // remove dependancys for non existant classes...
            foreach ($this->classChildren as $parent => $children)
            {
                if(!$this->classRegistry->fetch($parent))
                {
                    $class = new cfhCompile_Class_Manual($parent);
                    $this->classRegistry->register($class);
                    $this->notify(cfhCompile_Compiler_Event::EVENT_NOTFOUND, $class);
                    $this->classesWritten[$parent] = TRUE;
                    unset($this->classChildren[$parent]);
                    foreach ($children as $child)
                    {
                        $this->checkDependancysAndWrite($this->classRegistry->fetch($child));
                    }
                }
            }
            // loop through dependancys and try to write classes that
            // have all the dependancys written.
            do
            {
                $total = count($this->classesWritten);
                foreach ($this->classChildren as $parent => $children)
                {
                    $this->checkDependancysAndWrite($this->classRegistry->fetch($parent));
                }
            }
            while($total != count($this->classesWritten));
            // Loop through all classes and make sure they are written.
            foreach ($this->classRegistry as $class)
            {
                $this->write($class);
            }
            $this->classChildren  = array();
            $this->classesWritten = array();
            $this->notify(cfhCompile_Compiler_Event::EVENT_COMMIT);
            $this->codeWriter->commit($this->classRegistry);
            $this->classRegistry->clear();
        }
        catch (Exception $e)
        {
            $this->notify(cfhCompile_Compiler_Event::EVENT_ROLLBACK);
            $this->codeWriter->rollback($this->classRegistry);
            $this->classRegistry->clear();
            throw $e;
        }
    }

    /**
     * @return cfhCompile_Compiler_Event
     */
    protected function notify($event, cfhCompile_Class_Interface $class = NULL)
    {
        $event = new cfhCompile_Compiler_Event(
                                              $event,
                                              $this,
                                              $this->classIterator,
                                              $this->codeReader,
                                              $this->codeWriter,
                                              $this->classRegistry,
                                              $class
                                              );
        foreach($this->observers as $o)
        {
            $o->notify($event);
        }
    }

    protected function checkDependancysAndWrite(cfhCompile_Class_Interface $class)
    {
        $canWrite = TRUE;
        foreach ($class->getDependancys() as $depend)
        {
            if(!isset($this->classesWritten[$depend]))
            {
                $canWrite = FALSE;
                if(!isset($this->classChildren[$depend]))
                {
                    $this->classChildren[$depend] = array();
                }
                $this->classChildren[$depend][] = $class->getName();
            }
        }
        if($canWrite)
        {
            $this->write($class);
            if(isset($this->classChildren[$class->getName()]))
            {
                foreach ($this->classChildren[$class->getName()] as $child)
                {
                    $this->checkDependancysAndWrite($this->classRegistry->fetch($child));
                }
            }
            unset($this->classChildren[$class->getName()]);
        }
    }

    protected function write(cfhCompile_Class_Interface $class)
    {
        if(isset($this->classesWritten[$class->getName()]))
        {
            return;
        }
        $this->classesWritten[$class->getName()] = TRUE;
        $source = $this->codeReader->getSourceCode($class);
        if($source !== NULL)
        {
            $this->notify(cfhCompile_Compiler_Event::EVENT_WRITE, $class);
            $this->codeWriter->write(
                                    $class,
                                    $source,
                                    $this->classRegistry
                                    );
        }
        else
        {
            $this->notify(cfhCompile_Compiler_Event::EVENT_SKIP, $class);
        }
    }

}