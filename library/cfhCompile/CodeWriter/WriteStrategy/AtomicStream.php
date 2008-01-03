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
 * Writes source code to a stream an an atomic manner.
 *
 * The stream must support file_exists, rename and unlink operations.
 *
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeWriter
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_CodeWriter_WriteStrategy_AtomicStream
implements cfhCompile_CodeWriter_WriteStrategy_Interface
{

    const EXT_TEMP    = '.temp';
    const EXT_BACKUP  = '.backup';
    const WRITE_RETRY = 20;

    protected $url;
    protected $tempUrl;
    protected $fp;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = (string) $url;
    }

    /**
     * Begin a code writer process.
     * @throws cfhCompile_CodeWriter_Exception
     */
    public function begin()
    {
        $this->tempUrl = $this->url.uniqid('.').self::EXT_TEMP;
        $this->fp      = @fopen($this->tempUrl, 'xb');
        if(!is_resource($this->fp))
        {
            throw new cfhCompile_CodeWriter_Exception('Unable to open url '.$this->tempUrl);
        }
        fwrite($this->fp, '<?php ');
    }

    /**
     * Rollback a code writer process.
     * @param cfhCompile_ClassRegistry $classRegistry
     * @throws cfhCompile_CodeWriter_Exception
     */
    public function rollback(cfhCompile_ClassRegistry $classRegistry)
    {
        if($this->tempUrl === NULL)
        {
            throw new cfhCompile_CodeWriter_Exception('Cant rollback() without begin()');
        }
        if(is_resource($this->fp))
        {
            fclose($this->fp);
        }
        $this->fp = NULL;
        if(file_exists($this->tempUrl))
        {
            if(!@unlink($this->tempUrl))
            {
                throw new cfhCompile_CodeWriter_Exception('Unable to unlink '.$this->tempUrl);
            }
        }
        $this->tempUrl = NULL;
    }

    /**
     * Commit a code writer process.
     * @param cfhCompile_ClassRegistry $classRegistry
     * @throws cfhCompile_CodeWriter_Exception
     */
    public function commit(cfhCompile_ClassRegistry $classRegistry)
    {
        if($this->tempUrl === NULL)
        {
            throw new cfhCompile_CodeWriter_Exception('Cant commit() without begin()');
        }
        fclose($this->fp);
        $this->fp  = NULL;
        $backupUrl = NULL;
        if(file_exists($this->url))
        {
            $backupUrl = $this->url.uniqid('.').self::EXT_BACKUP;
            if(!@rename($this->url, $backupUrl))
            {
                throw new cfhCompile_CodeWriter_Exception('Unable to rename '.$this->url.' to '.$backupUrl);
            }
        }
        if(!@rename($this->tempUrl, $this->url))
        {
            if(!@rename($backupUrl, $this->url))
            {
                throw new cfhCompile_CodeWriter_Exception('Unable to rename '.$backupUrl.' to '.$this->url);
            }
            throw new cfhCompile_CodeWriter_Exception('Unable to rename '.$this->tempUrl.' to '.$this->url);
        }
        if($backupUrl)
        {
            if(!@unlink($backupUrl))
            {
                throw new cfhCompile_CodeWriter_Exception('Unable to unlink '.$backupUrl);
            }
        }
        $this->tempUrl = NULL;
    }

    /**
     * Write a class.
     *
     * @param cfhCompile_Class_Interface $class
     * @param String $sourceCode
     * @param cfhCompile_ClassRegistry $classRegistry
     * @throws cfhCompile_CodeWriter_Exception
     */
    public function write(
                         cfhCompile_Class_Interface $class,
                         $sourceCode,
                         cfhCompile_ClassRegistry $classRegistry
                         )
    {
        $this->writeSource($sourceCode);
    }

    /**
     * Writes source code.
     *
     * @param String $sourceCode
     */
    public function writeSource($sourceCode)
    {
        if(!is_resource($this->fp))
        {
           throw new cfhCompile_CodeWriter_Exception('Invaild file pointer.');
        }
        $try  = 0;
        $code = $sourceCode;
        while($code)
        {
            if($try++ >= self::WRITE_RETRY)
            {
                throw new cfhCompile_CodeWriter_Exception('Failed to finish source code write after '.self::WRITE_RETRY.' attempts.');
            }
            $written = fwrite($this->fp, $code, strlen($code));
            $code    = substr($code, $written);
        }
    }

}