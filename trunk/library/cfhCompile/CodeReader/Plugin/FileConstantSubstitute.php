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
 * Substitutes __FILE__ with the real path of the file.
 *
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeReader
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeReader_Plugin_FileConstantSubstitute
extends cfhCompile_CodeReader_Plugin_Abstract
{

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
        if(is_null($sourceCode))
        {
            return NULL;
        }
        $tokens     = token_get_all('<?php'.PHP_EOL.$sourceCode);
        $sourceCode = '';
        foreach ($tokens as $token)
        {
            if(is_string($token))
            {
                $sourceCode .= $token;
            }
            else
            {
                list($token, $text) = $token;
                if($token == T_FILE)
                {
                    $text = "'".$class->getFileName()."'";
                }
                $sourceCode .= $text;
            }
        }
        return substr($sourceCode, strlen('<?php'.PHP_EOL));
    }

}