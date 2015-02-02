<?php
// namespace phamily\framework\tests;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

abstract class DbTest extends UnitTest{
	
	protected static $dbAdapter;
	
	public static function setConfig(array $config){
		self::$dbAdapter = new Adapter($config);
	}
	
	protected function setUp(){
		parent::setUp();
		$this->cleanupDb();
	}

	/**
	 * TODO move to configuration 
	 * @return multitype:string
	 */
	protected function getTablesWithData(){
		return ['gender'];
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
	static public function assertTableHasData($tableName, $rowData = [], $message = ''){
		$tableGateway = self::getTableGateway($tableName);
		$resultSet = $tableGateway->select($rowData);
		return self::assertGreaterThan(0, $resultSet->count(), $message);
	}
	
	/*
	 * 
	 */
	
	protected function insertRowInTable($rowData, $tableName){
		return $this->getTableGateway($tableName)->insert($rowData);
	}
	
	/**
	 *
	 * @return AdapterInterface
	 */
	static protected function getDbAdapter(){
		return self::$dbAdapter;
	}
	
	static protected function getTableGateway($tableName){
		return new TableGateway($tableName, self::getDbAdapter());
	}
	
	
	private function cleanupDb(){
		$platformName = $this->getDbAdapter()->getDriver()->getDatabasePlatformName();
		if($platformName === 'Mysql'){
			$connection = $this->getDbAdapter()->getDriver()->getConnection();
			$result = $connection->execute("SHOW TABLES;");
			$connection->execute("SET FOREIGN_KEY_CHECKS=0;");
			foreach ($result as $table){
				$tableName = $table["Tables_in_{$connection->getCurrentSchema()}"];
				if(!in_array($tableName, $this->getTablesWithData())){
					$connection->execute("TRUNCATE `{$tableName}`;");
				}
			}
			$connection->execute("SET FOREIGN_KEY_CHECKS=1;");
		}else{
			throw new \Exception("DB {$platformName} not supported in tests");
		}
	}	
	
}