<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class GenderTableCreate extends AbstractMigration
{

    public function up()
    {
        $genderTable = $this->table("gender", [
            'id' => false,
            'primary_key' => 'gender',
        ]);

        $genderTable->addColumn("gender", ColumnType::PHINX_TYPE_STRING, [
            ColumnOption::OPTION_LIMIT => 6,
            ColumnOption::OPTION_NULLABLE => false,
        ]);

        $genderTable->save();

    }

    public function down()
    {
        $this->dropTable("gender");
    }
}
