<?php
/**
 *
 * A simple example to show how to use the runtime class logger in your
 * application.
 *
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Examples
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

$base = realpath(dirname(__FILE__)).'/';

require_once $base.'../library/cfhCompile/Loader.php';
cfhCompile_Loader::registerAutoload();

$sqliteFile   = $base.'classlogger.sqlite';
$createTables = !file_exists($sqliteFile);
$pdo          = new PDO('sqlite:'.$sqliteFile);
if($createTables)
{
    $sqlFile = cfhCompile_Runtime_ClassLogger_Strategy_Database::getSqlPath()
             . DIRECTORY_SEPARATOR
             . 'SQLite3.sql'
             ;
    $pdo->exec(file_get_contents($sqlFile));
}
$loggerStrategy = new cfhCompile_Runtime_ClassLogger_Strategy_Database(
                                               $pdo,
                                               'cfhCompile Class Logger Example'
                                               );
$logger = new cfhCompile_Runtime_ClassLogger();
$logger->setStrategy($loggerStrategy);
register_shutdown_function(array($logger, 'log'));
