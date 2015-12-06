<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Table\ForeignKeyOptionEnum as FKOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class SpouseRelationship extends AbstractMigration
{

    public function up()
    {
        $this->table("spouse_relationship")->addColumn("husband_id", ColumnType::PHINX_TYPE_INTEGER, [
            ColumnOption::OPTION_NULLABLE => false,
        ])->addColumn("wife_id", ColumnType::PHINX_TYPE_INTEGER, [
            ColumnOption::OPTION_NULLABLE => false,
        ])->save();
    }

    public function down()
    {
        $this->table("spouse_relationship")->drop();
    }
}
