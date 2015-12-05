<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Table\ForeignKeyOptionEnum as FKOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class PersonaHasName extends AbstractMigration
{

    public function up()
    {
        $this->table("PersonaHasName", [
            "id" => false,
            'primary_key' => [
                "personaId",
                "nameId"
            ]
        ])
            ->addColumn("personaId", ColumnType::PHINX_TYPE_INTEGER, [
            ColumnOption::OPTION_NULLABLE => false
        ])
            ->addColumn("nameId", ColumnType::PHINX_TYPE_INTEGER, [
            ColumnOption::OPTION_NULLABLE => false
        ])
            ->save();
    }

    public function down(){
        $this->table("PersonaHasName")->drop();
    }
}
