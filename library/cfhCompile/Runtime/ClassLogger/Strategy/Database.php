<?php
/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Runtime
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 * @license     http://www.gnu.org/licenses/lgpl.html     Lesser GPL
 * @version     $Id$
 */

/**
 * @category    cfh
 * @package     cfhCompile
 * @subpackage  Runtime
 * @copyright   Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
 */
class cfhCompile_Runtime_ClassLogger_Strategy_Database
implements cfhCompile_Runtime_ClassLogger_Strategy_Interface
{

    /**
     * @var string
     */
    protected $appName;

    /**
     * @var PDO
     */
    protected $dbh;

    /**
     * @var PDOStatement
     */
    protected $stmtFileSelect;

    /**
     * @var PDOStatement
     */
    protected $stmtFileInsert;

    /**
     * @var PDOStatement
     */
    protected $stmtClassSelect;

    /**
     * @var PDOStatement
     */
    protected $stmtClassInsert;

    /**
     * @var PDOStatement
     */
    protected $stmtLogInsert;

    /**
     * Gets the path to the sql files provided by the library.
     *
     * @return String
     */
    static public function getSqlPath()
    {
        return dirname(__FILE__).DIRECTORY_SEPARATOR.'Database';
    }

    public function __construct(PDO $dbh, $appName)
    {
        $this->appName = (string) $appName;
        $this->dbh     = $dbh;
        $this->stmtFileSelect  = $this->dbh->prepare('
                                 SELECT file_id
                                 FROM   file
                                 WHERE  file_name = :file_name
                                 ');
        $this->stmtFileInsert  = $this->dbh->prepare('
                                 INSERT INTO file
                                 (file_name) VALUES (:file_name)
                                 ');
        $this->stmtClassSelect = $this->dbh->prepare('
                                 SELECT class_id
                                 FROM   class
                                 WHERE  class_name     = :class_name
                                   AND  file_id = :file_id
                                 ');
        $this->stmtClassInsert = $this->dbh->prepare('
                                 INSERT INTO class
                                 ( class_name,  file_id)
                                 VALUES
                                 (:class_name, :file_id)
                                 ');
        $this->stmtLogInsert   = $this->dbh->prepare('
                                 INSERT INTO occurance
                                 ( application_id,  instance_id,
                                   class_id      ,  timestamp)
                                 VALUES
                                 (:application_id, :instance_id,
                                  :class_id      , :timestamp)
                                 ');
    }

    public function begin()
    {
        $this->dbh->beginTransaction();
        $stmt = $this->dbh->prepare('
                                    SELECT application_id
                                    FROM   application
                                    WHERE  application_name = :application_name
                                    ');
        $stmt->bindValue(':application_name', $this->appName, PDO::PARAM_STR);
        $stmt->execute();
        $appId = $stmt->fetchColumn();
        $stmt->closeCursor();
        if(!$appId)
        {
            $stmt = $this->dbh->prepare('
                                        INSERT INTO application
                                        ( application_name)
                                        VALUES
                                        (:application_name)
                                        ');
            $stmt->bindValue(
                            ':application_name',
                            $this->appName,
                            PDO::PARAM_STR
                            );
            $stmt->execute();
            $appId = $this->dbh->lastInsertId();
        }
        $this->stmtLogInsert->bindValue(
                                       ':application_id',
                                       $appId,
                                       PDO::PARAM_INT
                                       );
        $this->stmtLogInsert->bindValue(
                                       ':instance_id',
                                       $this->getInstanceId(),
                                       PDO::PARAM_INT
                                       );
    }

    /**
     * @param cfhCompile_Class_Interface $class
     */
    public function log(cfhCompile_Class_Interface $class)
    {
        $this->stmtLogInsert->bindValue(
                                       ':class_id',
                                       $this->getClassId($class),
                                       PDO::PARAM_INT
                                       );
        $this->stmtLogInsert->bindValue(
                                       ':timestamp',
                                       $this->getTimestamp(),
                                       PDO::PARAM_INT
                                       );
        $this->stmtLogInsert->execute();
    }

    public function commit()
    {
        $this->dbh->commit();
    }

    public function rollback()
    {
        $this->dbh->rollBack();
    }

    /**
     * @param cfhCompile_Class_Interface $class
     * @return Integer
     */
    protected function getFileId(cfhCompile_Class_Interface $class)
    {
        $this->stmtFileSelect->bindValue(
                                        ':file_name',
                                        $class->getFileName(),
                                        PDO::PARAM_STR
                                        );
        $this->stmtFileSelect->execute();
        $id = $this->stmtFileSelect->fetchColumn();
        $this->stmtFileSelect->closeCursor();
        if(!$id)
        {
            $this->stmtFileInsert->bindValue(
                                            ':file_name',
                                            $class->getFileName(),
                                            PDO::PARAM_STR
                                            );
            $this->stmtFileInsert->execute();
            $id = $this->dbh->lastInsertId();
        }
        return $id;
    }

    /**
     * @param cfhCompile_Class_Interface $class
     * @return Integer
     */
    protected function getClassId(cfhCompile_Class_Interface $class)
    {
        $fileId = $this->getFileId($class);
        $this->stmtClassSelect->bindValue(
                                         ':class_name',
                                         $class->getName(),
                                         PDO::PARAM_STR
                                         );
        $this->stmtClassSelect->bindValue(
                                         ':file_id',
                                         $fileId,
                                         PDO::PARAM_INT
                                         );
        $this->stmtClassSelect->execute();
        $id = $this->stmtClassSelect->fetchColumn();
        $this->stmtClassSelect->closeCursor();
        if(!$id)
        {
            $this->stmtClassInsert->bindValue(
                                             ':class_name',
                                             $class->getName(),
                                             PDO::PARAM_STR
                                             );
            $this->stmtClassInsert->bindValue(
                                             ':file_id',
                                             $fileId,
                                             PDO::PARAM_INT
                                             );
            $this->stmtClassInsert->execute();
            $id = $this->dbh->lastInsertId();
        }
        return $id;
    }

    protected function getInstanceId()
    {
        $stmt = $this->dbh->prepare('
                                    INSERT INTO instance
                                    (timestamp) VALUES (:timestamp)
                                    ');
        $stmt->bindValue(':timestamp', $this->getTimestamp(), PDO::PARAM_INT);
        $stmt->execute();
        return $this->dbh->lastInsertId();
    }

    protected function getTimestamp()
    {
        return time();
    }

}