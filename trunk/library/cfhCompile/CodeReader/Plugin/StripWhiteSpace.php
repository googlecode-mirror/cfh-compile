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
 * Strip all white space from the source code.
 *
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeReader
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeReader_Plugin_StripWhiteSpace
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
        $tokens     = token_get_all('<?php '.$sourceCode);
        $sourceCode = '';
        $lastWasString = FALSE;
        while($token = current($tokens))
        {
            $nextIsString = is_string(next($tokens));
            prev($tokens);
            if(is_string($token))
            {
                $sourceCode .= $token;
                $lastWasString = TRUE;
            }
            else
            {
                list($token, $text) = $token;
                if($token == T_WHITESPACE)
                {
                    if($lastWasString === FALSE && $nextIsString === FALSE)
                    {
                        $sourceCode .= ' ';
                    }
                }
                else
                {
                    $sourceCode .= $text;
                }
                $lastWasString = FALSE;
            }
            next($tokens);
        }
        return trim(substr($sourceCode, 5));
    }

}