<?php

use yii\db\Migration;

/**
 * Class m190524_090857_delete_username_column_from_user_table
 */
class m190524_090857_delete_username_column_from_user_table extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%user}}', 'username');
    }

    public function down()
    {
        return false;
    }
}
