<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  ClassIterator
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  ClassIterator
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_ClassIterator_FileInfo
implements cfhCompile_ClassIterator_Interface
{

    /**
     * @var cfhCompile_Class_Interface
     */
    protected $current;

    /**
     * @var AppendIterator
     */
    protected $fileIterator;

    /**
     * @var SplObjectStorage
     */
    protected $nonTraversableItems;

    /**
     * @var array
     */
    protected $inspectedFiles = array();

    /**
     * @var array
     */
    protected $currentFileClasses = array();

    /**
     * @var cfhCompile_ClassIterator_FileInfo_FilterBroker
     */
    protected $filter;

    public function __construct()
    {
        $this->nonTraversableItems = new SplObjectStorage();
        $this->fileIterator        = new AppendIterator();
        $this->fileIterator->append($this->nonTraversableItems);
        $this->rewind();
        $this->filter = new cfhCompile_ClassIterator_FileInfo_FilterBroker();
    }

    public function current()
    {
        return $this->current;
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
        $this->current = NULL;
        if(count($this->currentFileClasses) > 0)
        {
            $this->current = array_shift($this->currentFileClasses);
            return;
        }
        do
        {
            $file = $this->fileIterator->current();
            if($this->fileIterator->valid())
            {
                $this->fileIterator->next();
            }
        }
        while($file
             && (
                !$file->isFile()
                || isset($this->inspectedFiles[$file->getRealPath()])
                || !$this->filter->accept($file)
                )
             );
        if($file === NULL)
        {
            return;
        }
        $this->inspectedFiles[$file->getRealPath()] = TRUE;
        // We add a new line to the code so that the tokeniser will give us a
        // last token item for classes that end on the last line of a file
        // without any trailing white space.
        $tokens      = token_get_all(@file_get_contents($file->getRealPath()).PHP_EOL);
        $depth       = -1;
        $className   = NULL;
        $startLine   = NULL;
        $endLine     = NULL;
        $isInterface = FALSE;
        $dependancys = array();
        $getDep      = FALSE;
        reset($tokens);
        do
        {
            $token = current($tokens);
            switch($depth)
            {
                case -1:
                    if(!is_string($token))
                    {
                        list($token, $text, $line) = $token;
                        switch($token)
                        {
                            case T_INTERFACE:
                                $isInterface = TRUE;
                            case T_CLASS:
                                $depth     = 0;
                                $startLine = $line;
                                $endLine   = NULL;
                                break;
                        }
                    }
                    break;
                case 0:
                    list($token, $text) = $token;
                    switch($token)
                    {
                        case T_STRING:
                            $className = $text;
                            $depth = 1;
                            break;
                    }
                    break;
                case 1:
                    if(is_string($token))
                    {
                        if($token == '{')
                        {
                            $depth = 3;
                        }
                    }
                    else
                    {
                        list($token, $text) = $token;
                        switch($token)
                        {
                            case T_EXTENDS:
                                $getDep = TRUE;
                                break;
                            case T_IMPLEMENTS:
                                $getDep = TRUE;
                                break;
                            case T_STRING:
                                if($getDep)
                                {
                                    $dependancys[] = $text;
                                }
                                break;
                            case T_WHITESPACE:
                                break;
                            default:
                                $getDep = FALSE;
                                break;
                        }
                    }
                    break;
                default:
                    if(is_string($token))
                    {
                        switch ($token)
                        {
                            case '{';
                                $depth++;
                                break;
                            case '}';
                                $depth--;
                                break;
                        }
                    }
                    else
                    {
                        list($token, $text, $endLine) = $token;
                        switch($token)
                        {
                            case T_CURLY_OPEN:
                            case T_DOLLAR_OPEN_CURLY_BRACES:
                                $depth++;
                                break;
                        }
                        if($depth == 2)
                        {
                            $depth = -1;
                            prev($tokens);
                            $class = new cfhCompile_Class_Manual(
                                         $className,
                                         $file->getRealPath(),
                                         $startLine,
                                         $endLine,
                                         $isInterface,
                                         new ArrayIterator($dependancys)
                                         );
                            array_push(
                                      $this->currentFileClasses,
                                      $class
                                      );
                            $className   = NULL;
                            $startLine   = NULL;
                            $endLine     = NULL;
                            $isInterface = FALSE;
                            $dependancys = array();
                            $getDep      = FALSE;
                        }
                    }
                    break;
            }
        }while(next($tokens));
        $this->next();
    }

    public function rewind()
    {
        $this->fileIterator->rewind();
        $this->inspectedFiles = array();
        $this->next();
    }

    public function valid()
    {
        return $this->current() instanceof cfhCompile_Class_Interface;
    }

    public function attach(splFileInfo $fileInfo)
    {
        if($fileInfo instanceof Iterator)
        {
            if($fileInfo instanceof RecursiveDirectoryIterator)
            {
                $this->fileIterator->append(new RecursiveIteratorIterator($fileInfo));
            }
            else
            {
                $this->fileIterator->append($fileInfo);
            }
        }
        else
        {
            $this->nonTraversableItems->attach($fileInfo);
        }
    }

    public function attachFilter(cfhCompile_ClassIterator_FileInfo_Filter_Interface $filter)
    {
        $this->filter->attach($filter);
    }

    public function detachFilter(cfhCompile_ClassIterator_FileInfo_Filter_Interface $filter)
    {
        $this->filter->detach($filter);
    }

}