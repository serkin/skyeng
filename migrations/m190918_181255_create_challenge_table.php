<?php

use yii\db\Migration;

/**
 * Handles the creation for table `challenge`.
 */
class m190918_181255_create_challenge_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('challenge', [
            'id_challenge' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'amount' => $this->integer()
        ]);

        $this->createIndex(
            'id_challenge',
            'challenge',
            'id_challenge'
        );
    }
    


    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('challenge');

        $this->dropIndex(
            'id_challenge',
            'challenge'
        );
    }
}
