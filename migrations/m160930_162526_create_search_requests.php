<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m160930_162526_create_search_requests extends Migration
{
    public function up()
    {
        $this->createTable('search_requests', [
            'id'        => Schema::TYPE_PK,
            'request'   => Schema::TYPE_STRING . ' NOT NULL',
            'c_time'    => Schema::TYPE_TIMESTAMP,
        ]);
    }

    public function down()
    {
        echo "m160930_162526_create_search_requests cannot be reverted.\n";

        return false;
    }
}
