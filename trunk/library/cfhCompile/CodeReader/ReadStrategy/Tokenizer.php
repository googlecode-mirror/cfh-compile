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
 *
 * Uses the php Tokenizer extension to read source code.
 *
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  CodeReader
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_CodeReader_ReadStrategy_Tokenizer
implements cfhCompile_CodeReader_ReadStrategy_Interface
{

    /**
     * Gets the source code for the specified class.
     *
     * @param cfhCompile_Class_Interface $class
     * @return String
     */
    public function getSourceCode(cfhCompile_Class_Interface $class)
    {
        if($class->getFileName() === NULL)
        {
            return NULL;
        }
        $code = @file($class->getFileName(), FILE_IGNORE_NEW_LINES);
        if($code === FALSE){
            throw new cfhCompile_CodeReader_Exception(
                      'Unable to read contents of '.$class->getFileName()
                      );
        }
        $offset = $class->getStartLine() - 1;
        $length = $class->getEndLine() - $offset;
        $code   = trim(implode(PHP_EOL, array_slice($code, $offset, $length)));
        if(!preg_match('/^(<\?(php){0,1}\s)/', $code))
        {
            // make sure that we start in PHP mode for the tokenizer.
            $code = '<?php'.PHP_EOL.$code;
        }
        $tokens = token_get_all($code);
        $code   = '';
        $depth  = -1;
        foreach ($tokens as $token) {
            switch($depth)
            {
                case -1:
                    if(!is_string($token))
                    {
                        list($token, $text) = $token;
                        switch($token)
                        {
                            case T_ABSTRACT:
                            case T_FINAL:
                                $code .= $text;
                                break;
                            case T_CLASS:
                            case T_INTERFACE:
                                $code  .= $text;
                                $depth = 0;
                                break;
                            case T_WHITESPACE:
                                if($code != '')
                                {
                                    $code .= $text;
                                }
                                break;
                        }
                    }
                    break;
                case 0:
                    list($token, $text) = $token;
                    switch($token)
                    {
                        case T_WHITESPACE:
                            $code .= $text;
                            break;
                        case T_STRING:
                            if($text == $class->getName())
                            {
                                $code .= $text;
                                $depth = 1;
                            }
                            else
                            {
                                $code  = '';
                                $depth = -1;
                            }
                            break;
                    }
                    break;
                default:
                    if(is_string($token))
                    {
                        $code .= $token;
                        switch ($token)
                        {
                            case '{';
                                $depth++;
                                break;
                            case '}';
                                $depth--;
                                if($depth == 1)
                                {
                                    break 3;
                                }
                                break;
                        }
                    }
                    else
                    {
                        list($token, $text) = $token;
                        $code .= $text;
                    }
                    break;
            }
        }
        return $code;
    }

}