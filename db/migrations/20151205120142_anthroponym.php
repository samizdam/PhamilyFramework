<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class Anthroponym extends AbstractMigration
{

    public function up()
    {
        $this->table("Anthroponym")
            ->addColumn("type", ColumnType::PHINX_TYPE_STRING, [
            ColumnOption::OPTION_LIMIT => 255,
            ColumnOption::OPTION_NULLABLE => false
        ])
            ->addColumn("value", ColumnType::PHINX_TYPE_STRING, [
            ColumnOption::OPTION_NULLABLE => false
        ])
            ->save();
    }

    public function down()
    {
        $this->dropTable("Anthroponym");
    }
}
