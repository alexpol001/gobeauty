<?php

use yii\db\Migration;

/**
 * Class m190524_084601_add_user_columns
 */
class m190524_084601_add_user_columns extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'is_subscribe', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%user}}', 'is_client', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%user}}', 'is_master', $this->boolean()->defaultValue(false));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'is_subscribe');
        $this->dropColumn('{{%user}}', 'is_client');
        $this->dropColumn('{{%user}}', 'is_master');
    }
}
