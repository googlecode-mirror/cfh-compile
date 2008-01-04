<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @group       cfhCompile
 * @group       cfhCompile_Runtime
 * @group       cfhCompile_Runtime_ClassLogger_Strategy
 * @group       cfhCompile_Runtime_ClassLogger_Strategy_Database
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_Runtime_ClassLogger_Strategy_DatabaseTest
extends PHPUnit_Extensions_Database_TestCase
{

    /**
     * @var PDO
     */
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('sqlite::memory:');
        $sql = cfhCompile_Runtime_ClassLogger_Strategy_Database::getSqlPath()
             . DIRECTORY_SEPARATOR
             . 'SQLite3.sql'
             ;
        if(!is_readable($sql))
        {
            $this->markTestSkipped('Unable to read sql file.');
            return;
        }
        $this->pdo->exec(file_get_contents($sql));
    }
    protected function getConnection()
    {
        return $this->createDefaultDBConnection($this->pdo, 'sqlite');
    }

    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(
                                          dirname(__FILE__)
                                          .'/.resource/database-seed.xml'
                                          );
    }

    public function testRollback()
    {
        $l = new cfhCompile_Runtime_ClassLogger_Strategy_Database(
                                                                 $this->pdo,
                                                                 'test'
                                                                 );
        $l->begin();
        $l->log(new cfhCompile_Class_Reflection($this));
        $l->rollback();
        $this->assertDataSetsEqual($this->getDataSet(), $this->getConnection()->createDataSet());
    }

    public function testCommit()
    {
        $c = new cfhCompile_Class_Manual(
                                        'test_class',
                                        '/path/to/test/class.php'
                                        );
        $l = $this->getMock(
                           'cfhCompile_Runtime_ClassLogger_Strategy_Database',
                           array('getTimestamp'),
                           array($this->pdo, 'test')
                           );
        $l->expects($this->any())
          ->method('getTimestamp')
          ->will($this->returnValue('1111111111'))
          ;
        $l->begin();
        $l->log($c);
        $l->commit();
        $dataSet = $this->createFlatXMLDataSet(
                                          dirname(__FILE__)
                                          .'/.resource/database-commit.xml'
                                          );
        $this->assertDataSetsEqual(
                                  $dataSet,
                                  $this->getConnection()->createDataSet()
                                  );
    }

    public function testNewInstance()
    {
        $cBar = new cfhCompile_Class_Manual(
                                           'bar',
                                           '/path/to/foo/classes.php'
                                           );
        $cBaz = new cfhCompile_Class_Manual(
                                           'baz',
                                           '/path/to/foo/classes.php'
                                           );
        $l = $this->getMock(
                           'cfhCompile_Runtime_ClassLogger_Strategy_Database',
                           array('getTimestamp'),
                           array($this->pdo, 'foo')
                           );
        $l->expects($this->any())
          ->method('getTimestamp')
          ->will($this->returnValue('1111111111'))
          ;
        $l->begin();
        $l->log($cBar);
        $l->log($cBaz);
        $l->commit();
        $dataSet = $this->createFlatXMLDataSet(
                                          dirname(__FILE__)
                                          .'/.resource/database-newinstance.xml'
                                          );
        $this->assertDataSetsEqual(
                                  $dataSet,
                                  $this->getConnection()->createDataSet()
                                  );
    }

    public function testNewInstance2()
    {
        $cBar = new cfhCompile_Class_Manual(
                                           'bar',
                                           '/path/to/foo/classes.php'
                                           );
        $cBaz = new cfhCompile_Class_Manual(
                                           'baz',
                                           '/path/to/foo/classes.php'
                                           );
        $l = $this->getMock(
                           'cfhCompile_Runtime_ClassLogger_Strategy_Database',
                           array('getTimestamp'),
                           array($this->pdo, 'foo')
                           );
        $l->expects($this->any())
          ->method('getTimestamp')
          ->will($this->onConsecutiveCalls(
                                          '1111111110',
                                          '1111111111',
                                          '1111111112',
                                          '1111111113',
                                          '1111111114',
                                          '1111111115'
                                          ))
          ;
        // First run...
        $l->begin();
        $l->log($cBar);
        $l->log($cBaz);
        $l->commit();
        // Second run...
        $l->begin();
        $l->log($cBar);
        $l->log($cBaz);
        $l->commit();
        $dataSet = $this->createFlatXMLDataSet(
                                          dirname(__FILE__)
                                          .'/.resource/database-newinstance2.xml'
                                          );
        $this->assertDataSetsEqual(
                                  $dataSet,
                                  $this->getConnection()->createDataSet()
                                  );
    }

}