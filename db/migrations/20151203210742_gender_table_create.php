<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\ColumnOptionEnum as ColumnOption;
use Phinx\Db\Adapter\PhinxTypeEnum as ColumnType;

class GenderTableCreate extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $genderTable = $this->table("Gender", [
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
        $this->dropTable("Gender");
    }
}
