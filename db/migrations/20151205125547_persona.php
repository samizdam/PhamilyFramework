<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class Persona extends AbstractMigration
{

    public function up()
    {
        $this->table("persona")
            ->addColumn("father_id", ColumnType::PHINX_TYPE_INTEGER, [
            ColumnOption::OPTION_NULLABLE => true,
            ColumnOption::OPTION_DEFAULT => null
        ])
            ->addColumn("mother_id", ColumnType::PHINX_TYPE_INTEGER, [
            ColumnOption::OPTION_NULLABLE => true,
            ColumnOption::OPTION_DEFAULT => null
        ])
            ->addColumn("gender", ColumnType::PHINX_TYPE_STRING, [
            ColumnOption::OPTION_NULLABLE => true,
            ColumnOption::OPTION_LIMIT => 6
        ])
            ->addColumn("date_of_birth", ColumnType::PHINX_TYPE_BIG_INTEGER, [
            ColumnOption::OPTION_DEFAULT => null,
            ColumnOption::OPTION_NULLABLE => true
        ])
            ->addColumn("date_of_death", ColumnType::PHINX_TYPE_BIG_INTEGER, [
            ColumnOption::OPTION_DEFAULT => null,
            ColumnOption::OPTION_NULLABLE => true
        ])
            ->addTimestamps()
            ->save();
    }

    public function down()
    {
        $this->table("Persona")->drop();
    }
}
