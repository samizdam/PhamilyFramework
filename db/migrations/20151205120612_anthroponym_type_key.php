<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class AnthroponymTypeKey extends AbstractMigration
{

    public function up()
    {
        $this->table("anthroponym")
            ->addForeignKey("type", "anthroponym_type", "anthroponym_type", [
            "update" => "cascade",
            "delete" => "restrict",
            "constraint" => "fk_anthroponym_to_anthroponym_type"
        ])
            ->save();
    }

    public function down()
    {
        $this->table("anthroponym")->dropForeignKey("type", "fk_anthroponym_to_anthroponym_type");
    }
}
