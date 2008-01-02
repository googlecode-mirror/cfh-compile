<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @group       cfhCompile
 * @group       cfhCompile_Runtime
 * @group       cfhCompile_Runtime_ClassLogger
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  UnitTests
 * @copyright   Copyright (c) 2007 William Bailey
 */
class cfhCompile_Runtime_ClassLoggerTest
extends PHPUnit_Framework_TestCase
{

    public function testLogLoggerCalls()
    {
        $loggerStrategy = $this->getMock('cfhCompile_Runtime_ClassLogger_Strategy_Interface');
        $loggerStrategy->expects($this->once())
                       ->method('begin')
                       ;
        $loggerStrategy->expects($this->atLeastOnce())
                       ->method('log')
                       ->with($this->isInstanceOf('cfhCompile_Class_Interface'))
                       ;
        $loggerStrategy->expects($this->once())
                       ->method('commit')
                       ;
        $loggerStrategy->expects($this->never())
                       ->method('rollback')
                       ;
        $logger = new cfhCompile_Runtime_ClassLogger();
        $logger->setStrategy($loggerStrategy);
        $this->assertSame($loggerStrategy, $logger->getStrategy());
        $logger->log();
    }

    public function testLogLoggerCallsWithException()
    {
        $loggerStrategy = $this->getMock('cfhCompile_Runtime_ClassLogger_Strategy_Interface');
        $loggerStrategy->expects($this->once())
                       ->method('begin')
                       ;
        $loggerStrategy->expects($this->atLeastOnce())
                       ->method('log')
                       ->with($this->isInstanceOf('cfhCompile_Class_Interface'))
                       ->will($this->throwException(new Exception()))
                       ;
        $loggerStrategy->expects($this->never())
                       ->method('commit')
                       ;
        $loggerStrategy->expects($this->once())
                       ->method('rollback')
                       ;
        $logger = new cfhCompile_Runtime_ClassLogger();
        $logger->setStrategy($loggerStrategy);
        $this->assertSame($loggerStrategy, $logger->getStrategy());
        try
        {
            $logger->log();
        }
        catch(Exception $e)
        {
            return;
        }
        $this->fail('Expecting to catch an exception.');
    }

}