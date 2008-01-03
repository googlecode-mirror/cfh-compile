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
 * Strip all comments from the source code.
 *
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeWriter
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_CodeWriter_Plugin_StripComments
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
                if($token != T_COMMENT && $token != T_DOC_COMMENT)
                {
                    $sourceCode .= $text;
                }
            }
        }
        return substr($sourceCode, strlen('<?php'.PHP_EOL));
    }
}