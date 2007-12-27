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
 * Strip all white space from the source code.
 *
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeWriter
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeWriter_Plugin_StripWhiteSpace
extends cfhCompile_CodeWriter_Plugin_Abstract
{

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