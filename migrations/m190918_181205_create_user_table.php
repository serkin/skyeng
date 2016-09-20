<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m190918_181205_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id_user' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'token' => $this->string()->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
