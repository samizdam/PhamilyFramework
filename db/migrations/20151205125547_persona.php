<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class Persona extends AbstractMigration
{

    public function up()
    {
        $this->table("Persona")
            ->addColumn("fatherId", ColumnType::PHINX_TYPE_INTEGER, [
            ColumnOption::OPTION_NULLABLE => true,
            ColumnOption::OPTION_DEFAULT => null
        ])
            ->addColumn("motherId", ColumnType::PHINX_TYPE_INTEGER, [
            ColumnOption::OPTION_NULLABLE => true,
            ColumnOption::OPTION_DEFAULT => null
        ])
            ->addColumn("gender", ColumnType::PHINX_TYPE_STRING, [
            ColumnOption::OPTION_NULLABLE => true,
            ColumnOption::OPTION_LIMIT => 6
        ])
            ->addColumn("dateOfBirth", ColumnType::PHINX_TYPE_BIG_INTEGER, [
            ColumnOption::OPTION_DEFAULT => null,
            ColumnOption::OPTION_NULLABLE => true
        ])
            ->addColumn("dateOfDeath", ColumnType::PHINX_TYPE_BIG_INTEGER, [
            ColumnOption::OPTION_DEFAULT => null,
            ColumnOption::OPTION_NULLABLE => true
        ])
            ->addTimestamps("createdAt", "updatedAt")
            ->save();
    }

    public function down()
    {
        $this->table("Persona")->drop();
    }
}
