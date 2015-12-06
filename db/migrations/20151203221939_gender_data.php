<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class GenderData extends AbstractMigration
{

    public function up()
    {
        $this->table("gender")->insert([
            ["gender" => "male"],
            ["gender" => "female"],
        ])->update();
    }

    public function down()
    {
        $this->execute("delete from gender");
    }
}
