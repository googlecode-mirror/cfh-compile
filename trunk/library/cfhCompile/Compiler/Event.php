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
class cfhCompile_Compiler_Event
{

    const EVENT_BEGIN    = 1;
    const EVENT_CLASS    = 2;
    const EVENT_WRITE    = 3;
    const EVENT_SKIP     = 4;
    const EVENT_COMMIT   = 5;
    const EVENT_ROLLBACK = 6;

    static protected $counter = 0;

    /**
     * @var Integer
     */
    protected $id;
    /**
     * @var Integer
     */
    protected $event;
    /**
     * @var cfhCompile_Compiler
     */
    protected $compiler;
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
     * @var cfhCompile_Class_Interface
     */
    protected $class;


    public function __construct(
                           $event,
                           cfhCompile_Compiler $compiler,
                           cfhCompile_ClassIterator_Interface $classIterator,
                           cfhCompile_CodeReader_ReadStrategy_Interface $reader,
                           cfhCompile_CodeWriter_Interface $writer,
                           cfhCompile_ClassRegistry $classRegistry,
                           cfhCompile_Class_Interface $class = NULL
                           )
    {
        $this->id            = ++self::$counter;
        $this->event         = (integer) $event;
        $this->compiler      = $compiler;
        $this->classIterator = $classIterator;
        $this->codeReader    = $reader;
        $this->codeWriter    = $writer;
        $this->classRegistry = $classRegistry;
        $this->class         = $class;
    }

    public function __clone()
    {
        $this->id = ++self::$counter;
    }

    public function __sleep()
    {
        throw new cfhCompile_Compiler_Exception('Compiler events can not be serialized.');
    }

    /**
     * @return Integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Integer
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return cfhCompile_Compiler
     */
    public function getCompiler()
    {
        return $this->compiler;
    }

    /**
     * @return cfhCompile_ClassIterator_Interface
     */
    public function getClassIterator()
    {
        return $this->classIterator;
    }

    /**
     * @return cfhCompile_CodeReader_ReadStrategy_Interface
     */
    public function getCodeReader()
    {
        return $this->codeReader;
    }

    /**
     * @return cfhCompile_CodeWriter_Interface
     */
    public function getCodeWriter()
    {
        return $this->codeWriter;
    }

    /**
     * @return cfhCompile_ClassRegistry
     */
    public function getClassRegistry()
    {
        return $this->classRegistry;
    }

    /**
     * @return cfhCompile_Class_Interface
     */
    public function getClass()
    {
        return $this->class;
    }

}