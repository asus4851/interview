<?php

use yii\db\Schema;
use yii\db\Migration;

class m151221_182314_init_employee extends Migration
{
    public $tableName = 'employee';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id'        => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'full_name' => $this->string(255)->notNull(),
            'position'  => $this->string(100)->notNull(),
            'date'      => $this->date()->notNull(),
            'salary'    => $this->integer()->notNull()->defaultValue(0),
            'photo'    => $this->string(255)->notNull(),
        ]);

        $this->createIndex('parent_id_idx', $this->tableName, 'parent_id');
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
