<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m160930_150710_create_search_requests extends Migration
{
    public function up()
    {
        $this->createTable('search_requests', [
            'id'        => Schema::TYPE_PK,
            'request'   => Schema::TYPE_STRING . ' NOT NULL',
            'c_time'    => Schema::TYPE_DATETIME,
        ]);
    }

    public function down()
    {
        echo "m160930_150710_create_search_requests cannot be reverted.\n";

        return false;
    }
}
