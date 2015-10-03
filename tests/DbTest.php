<?php
namespace phamily\tests;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

abstract class DbTest extends UnitTest
{

    protected static $dbAdapter;

    public static function setConfig(array $config)
    {
        self::$dbAdapter = new Adapter($config);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->cleanupDb();
    }

    /**
     * TODO move to configuration
     * 
     * @return multitype:string
     */
    protected function getTablesWithData()
    {
        return [
            'gender'
        ];
    }

    /*
     * asserts
     */
    
    /**
     *
     * @param string $tableName            
     * @param array $rowData            
     * @param string $message            
     */
    static public function assertTableHasData($tableName, $rowData = [], $message = '')
    {
        $tableGateway = self::getTableGateway($tableName);
        $resultSet = $tableGateway->select($rowData);
        return self::assertGreaterThan(0, $resultSet->count(), $message);
    }

    /**
     *
     * @param string $tableName            
     * @param array $rowData            
     * @param string $message            
     */
    static public function assertTableHasNotData($tableName, $rowData = [], $message = '')
    {
        $tableGateway = self::getTableGateway($tableName);
        $resultSet = $tableGateway->select($rowData);
        return self::assertEquals(0, $resultSet->count(), $message);
    }

    /*
     *
     */
    protected function insertRowInTable($rowData, $tableName)
    {
        return $this->getTableGateway($tableName)->insert($rowData);
    }

    /**
     *
     * @return AdapterInterface
     */
    static public function getDbAdapter()
    {
        return self::$dbAdapter;
    }

    static protected function getTableGateway($tableName)
    {
        return new TableGateway($tableName, self::getDbAdapter());
    }

    private function cleanupDb()
    {
        $connection = $this->getDbAdapter()
            ->getDriver()
            ->getConnection();
        
        foreach ($this->getTables() as $tableName) {
            if (! in_array($tableName, $this->getTablesWithData())) {
                $this->truncate($tableName);
            }
        }
    }

    private function getTables()
    {
        $platformName = $this->getDbAdapter()
            ->getDriver()
            ->getDatabasePlatformName();
        $connection = $this->getDbAdapter()
            ->getDriver()
            ->getConnection();
        $schema = $connection->getCurrentSchema();
        $tables = [];
        
        switch ($platformName) {
            case 'Mysql':
                
                $result = $connection->execute("SELECT table_name FROM information_schema.tables WHERE table_schema = '{$schema}';");
                break;
            case 'Postgresql':
                $result = $connection->execute("SELECT tablename AS table_name FROM pg_catalog.pg_tables where schemaname = '{$schema}';");
                break;
            default:
                throw new \Exception("DB {$platformName} not supported in tests");
        }
        foreach ($result as $table) {
            $tables[] = $table['table_name'];
        }
        return $tables;
    }

    protected function truncate($tableName, $forced = true)
    {
        $platformName = $this->getDbAdapter()
            ->getDriver()
            ->getDatabasePlatformName();
        $connection = $this->getDbAdapter()
            ->getDriver()
            ->getConnection();
        $schema = $connection->getCurrentSchema();
        switch ($platformName) {
            case 'Mysql':
                if ($forced) {
                    $connection->execute("SET FOREIGN_KEY_CHECKS=0;");
                }
                $connection->execute("TRUNCATE `{$tableName}`;");
                if ($forced) {
                    $connection->execute("SET FOREIGN_KEY_CHECKS=1;");
                }
                break;
            case 'Postgresql':
                $connection->execute("TRUNCATE {$tableName} RESTART IDENTITY CASCADE;");
                break;
            default:
                throw new \Exception("DB {$platformName} not supported in tests");
        }
    }
}