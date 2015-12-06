<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Table\ForeignKeyOptionEnum as FKOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class PersonaHasName extends AbstractMigration
{

    public function up()
    {
        $this->table("persona_has_name", [
            "id" => false,
            'primary_key' => [
                "persona_id",
                "name_id"
            ]
        ])
            ->addColumn("persona_id", ColumnType::PHINX_TYPE_INTEGER, [
            ColumnOption::OPTION_NULLABLE => false
        ])
            ->addColumn("name_id", ColumnType::PHINX_TYPE_INTEGER, [
            ColumnOption::OPTION_NULLABLE => false
        ])
            ->save();
    }

    public function down(){
        $this->table("persona_has_name")->drop();
    }
}
