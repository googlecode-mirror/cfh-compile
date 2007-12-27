<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeWriter
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeWriter
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeWriter
implements cfhCompile_CodeWriter_WriteStrategy_Interface
{

    /**
     * @var cfhCompile_CodeWriter_WriteStrategy_Interface
     */
    protected $write;

    /**
     * @var cfhCompile_CodeWriter_PluginBroker
     */
    protected $plugin;

    public function __construct()
    {
        $this->write  = new cfhCompile_CodeWriter_WriteStrategy_Null();
        $this->plugin = new cfhCompile_CodeWriter_PluginBroker();
    }

    /**
     * @return cfhCompile_CodeWriter_WriteStrategy_Interface
     */
    public function getWriteStrategy()
    {
        return $this->write;
    }

    /**
     * @param cfhCompile_CodeWriter_WriteStrategy_Interface $read
     */
    public function setWriteStrategy(cfhCompile_CodeWriter_WriteStrategy_Interface $read)
    {
        $this->write = $read;
    }

    /**
     * @param cfhCompile_CodeWriter_Plugin_Interface $plugin
     */
    public function attachPlugin(cfhCompile_CodeWriter_Plugin_Interface $plugin)
    {
        $this->plugin->attach($plugin);
    }

    /**
     * @param cfhCompile_CodeWriter_Plugin_Interface $plugin
     */
    public function detachPlugin(cfhCompile_CodeWriter_Plugin_Interface $plugin)
    {
        $this->plugin->detach($plugin);
    }


    /**
     * Begin a code writer process.
     */
    public function begin()
    {
        $this->plugin->preBegin($this);
        $this->write->begin();
        $this->plugin->postBegin($this);
    }

    /**
     * Rollback a code writer process.
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function rollback(cfhCompile_ClassRegistry $classRegistry)
    {
        $this->plugin->preRollback($this, $classRegistry);
        $this->write->rollback($classRegistry);
        $this->plugin->postRollback($this, $classRegistry);
    }

    /**
     * Commit a code writer process.
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function commit(cfhCompile_ClassRegistry $classRegistry)
    {
        $this->plugin->preCommit($this, $classRegistry);
        $this->write->commit($classRegistry);
        $this->plugin->postCommit($this, $classRegistry);
    }

    /**
     * Write a class.
     *
     * @param cfhCompile_Class_Interface $class
     * @param String $sourceCode
     * @param cfhCompile_ClassRegistry $classRegistry
     */
    public function write(
                         cfhCompile_Class_Interface $class,
                         $sourceCode,
                         cfhCompile_ClassRegistry $classRegistry
                         )
    {
        $sourceCode = $this->plugin->preWrite(
                                             $this,
                                             $class,
                                             $sourceCode,
                                             $classRegistry
                                             );
        $this->write->write($class, $sourceCode, $classRegistry);
        $this->plugin->postWrite($this, $class, $sourceCode, $classRegistry);
    }

    /**
     * Writes source code.
     *
     * @param String $sourceCode
     */
    public function writeSource($sourceCode)
    {
        $sourceCode = $this->plugin->preWriteSource(
                                                   $this,
                                                   $sourceCode
                                                   );
        $this->write->writeSource($sourceCode);
        $this->plugin->postWriteSource($this, $sourceCode);
    }

}