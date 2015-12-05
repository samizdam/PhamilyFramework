<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class AnthroponymTypeKey extends AbstractMigration
{

    public function up()
    {
        $this->table("Anthroponym")
            ->addForeignKey([
            "type"
        ], "AnthroponymType", [
            "anthroponymType"
        ], [
            "update" => "cascade",
            "delete" => "restrict",
            "constraint" => "fk_anthroponym_to_anthroponym_type"
        ])
            ->save();
    }

    public function down()
    {
        $this->table("Anthroponym")->dropForeignKey("type", "fk_anthroponym_to_anthroponym_type");
    }
}
