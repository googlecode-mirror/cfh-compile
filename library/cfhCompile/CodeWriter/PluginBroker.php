<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeWriter
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeWriter
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_CodeWriter_PluginBroker
implements cfhCompile_CodeWriter_Plugin_Interface
{

    /**
     * @var SplObjectStorage
     */
    protected $plugins;

    public function __construct()
    {
        $this->plugins = new SplObjectStorage();
    }

    public function attach(cfhCompile_CodeWriter_Plugin_Interface $plugin)
    {
        $this->plugins->attach($plugin);
    }

    public function detach(cfhCompile_CodeWriter_Plugin_Interface $plugin)
    {
        $this->plugins->detach($plugin);
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     */
    public function preBegin(cfhCompile_CodeWriter $codeWriter)
    {
        foreach ($this->plugins as $p)
        {
            $p->preBegin($codeWriter);
        }
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     */
    public function postBegin(cfhCompile_CodeWriter $codeWriter)
    {
        foreach ($this->plugins as $p)
        {
            $p->postBegin($codeWriter);
        }
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function preRollback(
                               cfhCompile_CodeWriter $codeWriter,
                               cfhCompile_ClassRegistry $classRegistry
                               )
    {
        foreach ($this->plugins as $p)
        {
            $p->preRollback($codeWriter, $classRegistry);
        }
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function postRollback(
                                cfhCompile_CodeWriter $codeWriter,
                                cfhCompile_ClassRegistry $classRegistry
                                )
    {
        foreach ($this->plugins as $p)
        {
            $p->postRollback($codeWriter, $classRegistry);
        }
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function preCommit(
                             cfhCompile_CodeWriter $codeWriter,
                             cfhCompile_ClassRegistry $classRegistry
                             )
    {
        foreach ($this->plugins as $p)
        {
            $p->preCommit($codeWriter, $classRegistry);
        }
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function postCommit(
                              cfhCompile_CodeWriter $codeWriter,
                              cfhCompile_ClassRegistry $classRegistry
                              )
    {
        foreach ($this->plugins as $p)
        {
            $p->postCommit($codeWriter, $classRegistry);
        }
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param cfhCompile_Class_Interface $class
     * @param unknown_type $sourceCode
     * @param cfhCompile_ClassRegistry $classRegistry
     * @return String
     */
    public function preWrite(
                            cfhCompile_CodeWriter $codeWriter,
                            cfhCompile_Class_Interface $class,
                            $sourceCode,
                            cfhCompile_ClassRegistry $classRegistry
                            )
    {
        if(trim($sourceCode) == '')
        {
            $sourceCode = NULL;
        }
        foreach ($this->plugins as $p)
        {
            $sourceCode = $p->preWrite(
                                      $codeWriter,
                                      $class,
                                      $sourceCode,
                                      $classRegistry
                                      );
            if(!is_string($sourceCode) && !is_null($sourceCode))
            {
                throw new cfhCompile_CodeWriter_Plugin_Exception(
                          get_class($p).'->preWriteSource() '.
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

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param cfhCompile_Class_Interface $class
     * @param unknown_type $sourceCode
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function postWrite(
                             cfhCompile_CodeWriter $codeWriter,
                             cfhCompile_Class_Interface $class,
                             $sourceCode,
                             cfhCompile_ClassRegistry $classRegistry
                             )
    {
        foreach ($this->plugins as $p)
        {
            $p->postWrite($codeWriter, $class, $sourceCode, $classRegistry);
        }
    }

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param unknown_type $sourceCode
     * @return String
     */
    public function preWriteSource(
                                  cfhCompile_CodeWriter $codeWriter,
                                  $sourceCode
                                  )
    {
        if(trim($sourceCode) == '')
        {
            $sourceCode = NULL;
        }
        foreach ($this->plugins as $p)
        {
            $sourceCode = $p->preWriteSource(
                                            $codeWriter,
                                            $sourceCode
                                            );
            if(!is_string($sourceCode) && !is_null($sourceCode))
            {
                throw new cfhCompile_CodeWriter_Plugin_Exception(
                          get_class($p).'->preWriteSource() '.
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

    /**
     * @param cfhCompile_CodeWriter $codeWriter
     * @param unknown_type $sourceCode
     */
    public function postWriteSource(
                                   cfhCompile_CodeWriter $codeWriter,
                                   $sourceCode
                                   )
    {
        foreach ($this->plugins as $p)
        {
            $p->postWriteSource($codeWriter, $sourceCode);
        }
    }



}