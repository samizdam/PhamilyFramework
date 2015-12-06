<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class AnthroponymTypeTable extends AbstractMigration
{

    public function up()
    {
        $this->table("anthroponym_type", [
            'id' => false,
            'primary_key' => 'anthroponym_type'
        ])
            ->addColumn("anthroponym_type", ColumnType::PHINX_TYPE_STRING, [
            ColumnOption::OPTION_LIMIT => 255,
            ColumnOption::OPTION_NULLABLE => false
        ])
            ->save();
    }

    public function down()
    {
        $this->dropTable("anthroponym_type");
    }
}
