<?php
/**
 *
 * Compiles the cfhCompile library and places the compiled file into the
 * tests directory. The unit test should pick up this file so we can then
 * run the unis tests to make sure that the compiled file is OK.
 *
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Examples
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

$base = realpath(dirname(__FILE__)).'/';

require_once $base.'../library/cfhCompile/Loader.php';

cfhCompile_Loader::registerAutoload();

$classIterator = new cfhCompile_ClassIterator_FileInfo();
$classIterator->attach(new RecursiveDirectoryIterator($base.'../library/cfhCompile'));
$classIterator->attachFilter(new cfhCompile_ClassIterator_FileInfo_Filter_FileExtension('.php'));

$codeReader  = new cfhCompile_CodeReader();
$codeReader->setReadStrategy(new cfhCompile_CodeReader_ReadStrategy_Tokenizer());

$codeWriter = new cfhCompile_CodeWriter();
$codeWriter->setWriteStrategy(new cfhCompile_CodeWriter_WriteStrategy_AtomicStream($base.'../tests/cfhCompile.compiled.php'));
$codeWriter->attachPlugin(new cfhCompile_CodeWriter_Plugin_FileConstantSubstitute());
$codeWriter->attachPlugin(new cfhCompile_CodeWriter_Plugin_StripComments());
$codeWriter->attachPlugin(new cfhCompile_CodeWriter_Plugin_StripWhiteSpace());
$codeWriter->attachPlugin(new cfhCompile_CodeWriter_Plugin_Padding());

$c = new cfhCompile_Compiler();
$c->setClassIterator($classIterator);
$c->setCodeReader($codeReader);
$c->setCodeWriter($codeWriter);
$c->attachObserver(new cfhCompile_Compiler_Observer_SimpleLogger(fopen('php://output', 'r')));
$c->compile();
