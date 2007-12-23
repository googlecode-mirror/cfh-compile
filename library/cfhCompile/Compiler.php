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
     * @var cfhCompile_CodeWriter_Interface
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

    public function setCodeWriter(cfhCompile_CodeWriter_Interface $w)
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
        if(!$this->codeWriter instanceof cfhCompile_CodeWriter_Interface)
        {
            throw new cfhCompile_Compiler_Exception('Invalid or undefined code writer.');
        }
        try
        {
            $this->classRegistry->clear();
            $this->notify(cfhCompile_Compiler_Event::EVENT_BEGIN);
            $this->codeWriter->begin();
            foreach ($this->classIterator as $class)
            {
                $this->classRegistry->register($class);
                $this->notify(cfhCompile_Compiler_Event::EVENT_CLASS, $class);
                $source = $this->codeReader->getSourceCode($class);
                if($source !== NULL)
                {
                    $this->notify(cfhCompile_Compiler_Event::EVENT_WRITE, $class);
                    $this->codeWriter->write(
                                            $class,
                                            $source,
                                            $this->classRegistry
                                            );
                    $source = NULL;
                }
                else
                {
                    $this->notify(cfhCompile_Compiler_Event::EVENT_SKIP, $class);
                }
            }
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

}