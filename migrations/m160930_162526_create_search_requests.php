<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m160930_162526_create_search_requests extends Migration
{
    public function up()
    {
        $this->createTable('search_requests', [
            'id'         => Schema::TYPE_PK,
            'request'    => Schema::TYPE_STRING . ' NOT NULL',
            'responce'   => Schema::TYPE_STRING . ' NOT NULL',
            'kladr_code' => Schema::TYPE_STRING . ' NOT NULL',
            'c_time'     => Schema::TYPE_TIMESTAMP,
        ]);

        $this->createIndex('i_kladr_code', 'search_requests', 'kladr_code');

        $this->createTable('search_requests_count', [
            'id'         => Schema::TYPE_PK,
            'kladr_code' => Schema::TYPE_STRING . ' NOT NULL',
            'count'      => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 1',
        ]);

        $this->createIndex('i_kladr_code', 'search_requests_count', 'kladr_code', true);
    }

    public function down()
    {
        echo "m160930_162526_create_search_requests cannot be reverted.\n";

        return false;
    }
}
