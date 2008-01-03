<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeReader
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeReader
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_CodeReader
implements cfhCompile_CodeReader_ReadStrategy_Interface
{

    /**
     * @var cfhCompile_CodeReader_ReadStrategy_Interface
     */
    protected $read;

    /**
     * @var cfhCompile_CodeReader_PluginBroker
     */
    protected $plugin;

    public function __construct()
    {
        $this->read   = new cfhCompile_CodeReader_ReadStrategy_Null();
        $this->plugin = new cfhCompile_CodeReader_PluginBroker();
    }

    /**
     * @return cfhCompile_CodeReader_ReadStrategy_Interface
     */
    public function getReadStrategy()
    {
        return $this->read;
    }

    /**
     * @param cfhCompile_CodeReader_ReadStrategy_Interface $read
     */
    public function setReadStrategy(cfhCompile_CodeReader_ReadStrategy_Interface $read)
    {
        $this->read = $read;
    }

    /**
     * @param cfhCompile_CodeReader_Plugin_Interface $plugin
     */
    public function attachPlugin(cfhCompile_CodeReader_Plugin_Interface $plugin)
    {
        $this->plugin->attach($plugin);
    }

    /**
     * @param cfhCompile_CodeReader_Plugin_Interface $plugin
     */
    public function detachPlugin(cfhCompile_CodeReader_Plugin_Interface $plugin)
    {
        $this->plugin->detach($plugin);
    }

    /**
     * Gets the source code for the specified class.
     *
     * @param cfhCompile_Class_Interface $class
     * @return String
     * @throws cfhCompile_CodeReader_Exception
     */
    public function getSourceCode(cfhCompile_Class_Interface $class)
    {
        $class  = $this->plugin->preGetSourceCode($this, $class);
        $source = $this->read->getSourceCode($class);
        if(!is_string($source) && !is_null($source))
        {
            throw new cfhCompile_CodeReader_Exception(
                      get_class($this->read).'->getSourceCode() '.
                      'failed to return NULL or a string.'
                      );
        }
        return $this->plugin->postGetSourceCode($this, $class, $source);
    }

}