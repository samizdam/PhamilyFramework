<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Table\ForeignKeyOptionEnum as FKOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class SpouseRelationship extends AbstractMigration
{

    public function up()
    {
        $this->table("SpouseRelationship")->addColumn("husbandId", ColumnType::PHINX_TYPE_INTEGER, [
            ColumnOption::OPTION_NULLABLE => false,
        ])->addColumn("wifeId", ColumnType::PHINX_TYPE_INTEGER, [
            ColumnOption::OPTION_NULLABLE => false,
        ])->save();
    }

    public function down()
    {
        $this->table("SpouseRelationship")->drop();
    }
}
