<?php
require __DIR__ .'/../../../vendor/autoload.php';
$config = require __DIR__ .'/../../../config.php';

use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\Ddl\CreateTable;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Ddl\Column\Column;
use Zend\Db\Sql\Ddl\Column\Integer;
use Zend\Db\Sql\Ddl\Column\Varchar;
use Zend\Db\Sql\Ddl\Column\BigInteger;
use Zend\Db\Sql\Ddl\Column\Time;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Platform\Mysql;
use Zend\Db\Sql\Ddl\Constraint\PrimaryKey;
use Zend\Db\Sql\Ddl\Constraint\ForeignKey;

$adapter = new Adapter($config['db']);
$driver = $adapter->getDriver();
$platform = new Mysql($driver);

class Timestamp extends Column{
	protected $specification = '%s %s';
	protected $type = 'TIMESTAMP';
	public function __construct($name, $nullable = false, $default = null, array $options = array())
	{
		$this->setName($name);
		$this->setNullable($nullable);
		$this->setDefault($default);
		$this->setOptions($options);
	}
}

// common table columns
$id = new Integer('id');
$gender = new Varchar('gender', 6);
$createdAt = new Timestamp('createdAt');

$genderTable = new CreateTable('gender');
$genderTable->addColumn($gender);

$genderPK = new PrimaryKey('gender');

$genderTable->addConstraint($genderPK);

print $genderTable->getSqlString($platform);

$personaTable = new CreateTable('persona');

$id = new Integer('id');
$gender = new Varchar('gender', 6);
$fatherId = new Integer('fatherId', true);
$motherId = new Integer('motherId', true);
$dateOfBirth = new BigInteger('dateOfBirth', true);
$dateOfDeath = new BigInteger('dateOfDeath', true);

$personaColumns = [
	$id,
	$fatherId,
	$motherId,
	$gender, 
	$dateOfBirth, 
	$dateOfDeath, 
	$createdAt
];

foreach ($personaColumns as $column){
	$personaTable->addColumn($column);
}

$personaPK = new PrimaryKey('id');

$genderFK = new ForeignKey('fk_persona_gender_to_gender', 'gender', 'gender', 'gender');
$fatherFk = new ForeignKey('fk_parent_father', 'fatherId', 'persona', 'id');
$motherFk = new ForeignKey('fk_parent_mother', 'motherId', 'persona', 'id');

$personaConstraits = [$genderFK, $fatherFk, $motherFk];
foreach ($personaConstraits as $constrait){
	$personaTable->addConstraint($constrait);
}

print($personaTable->getSqlString($platform));

// $sql = new Sql($adapter);

// $adapter->query(
// 		$sql->getSqlStringForSqlObject($ddl),
// 		$adapter::QUERY_MODE_EXECUTE
// );

