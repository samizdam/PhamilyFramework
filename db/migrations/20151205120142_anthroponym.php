<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class Anthroponym extends AbstractMigration
{

    public function up()
    {
        $this->table("anthroponym", [
            "id" => false,
            'primary_key' => [
                "type",
                "value"
            ]
        ])
            ->addColumn("id", ColumnType::PHINX_TYPE_INTEGER, [
            ColumnOption::OPTION_NULLABLE => false,
            ColumnOption::OPTION_ID => true
        ])
            ->addIndex([
            "id"
        ], [
            "unique" => true
        ])
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
        $this->dropTable("anthroponym");
    }
}
