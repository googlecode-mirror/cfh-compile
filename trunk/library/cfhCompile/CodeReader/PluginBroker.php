<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeReader
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeReader
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeReader_PluginBroker
implements cfhCompile_CodeReader_Plugin_Interface
{

    /**
     * @var SplObjectStorage
     */
    protected $plugins;

    public function __construct()
    {
        $this->plugins = new SplObjectStorage();
    }

    public function attach(cfhCompile_CodeReader_Plugin_Interface $plugin)
    {
        $this->plugins->attach($plugin);
    }

    public function detach(cfhCompile_CodeReader_Plugin_Interface $plugin)
    {
        $this->plugins->detach($plugin);
    }

    /**
     * Hook that gets called pre get source code.
     *
     * @param cfhCompile_CodeReader $codeReader
     * @param cfhCompile_Class_Interface $class
     * @return cfhCompile_Class_Interface
     * @throws cfhCompile_CodeReader_Plugin_Exception
     */
    public function preGetSourceCode(
                                     cfhCompile_CodeReader $codeReader,
                                     cfhCompile_Class_Interface $class
                                    )
    {
        foreach ($this->plugins as $p)
        {
            $class = $p->preGetSourceCode($codeReader, $class);
            if(!$class instanceof cfhCompile_Class_Interface)
            {
                throw new cfhCompile_CodeReader_Plugin_Exception(
                          get_class($p).'->preGetSourceCode() '.
                          'failed to return an instance of '.
                          'cfhCompile_Class_Interface.'
                          );
            }
        }
        return $class;
    }

    /**
     * Hook that gets called post get source code.
     *
     * @param cfhCompile_CodeReader $codeReader
     * @param cfhCompile_Class_Interface $class
     * @param string $sourceCode;
     * @return string The source code to return.
     * @throws cfhCompile_CodeReader_Plugin_Exception
     */
    public function postGetSourceCode(
                                      cfhCompile_CodeReader $codeReader,
                                      cfhCompile_Class_Interface $class,
                                      $sourceCode
                                     )
    {
        if(trim($sourceCode) == '')
        {
            $sourceCode = NULL;
        }
        foreach ($this->plugins as $p)
        {
            $sourceCode = $p->postGetSourceCode(
                                                $codeReader,
                                                $class,
                                                $sourceCode
                                               );
            if(!is_string($sourceCode) && !is_null($sourceCode))
            {
                throw new cfhCompile_CodeReader_Plugin_Exception(
                          get_class($p).'->postGetSourceCode() '.
                          'failed to return NULL or a string.'
                          );
            }
            if(trim($sourceCode) == '')
            {
                $sourceCode = NULL;
            }
        }
        return $sourceCode;
    }


}