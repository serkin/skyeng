<?php

use yii\db\Migration;

/**
 * Handles the creation for table `history`.
 */
class m190918_181307_create_history_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('history', [
            'id_history' => $this->primaryKey(),
            'id_challenge' => $this->integer()->notNull(),
            'id_word' => $this->integer()->notNull(),
            'id_chosen_word' => $this->integer()->notNull(),
            'correct' => $this->integer(1)->defaultValue(0),
            'created_at' => $this->timestamp(),
            'UNIQUE KEY unique_histoy (id_challenge, id_word)',
        ]);

        $this->createIndex(
            'id_challenge',
            'history',
            'id_challenge'
        );

        $this->addForeignKey(
            'history_ibfk_1',
            'history',
            'id_challenge',
            'challenge',
            'id_challenge',
            'CASCADE'
        );


        $this->createIndex(
            'id_word',
            'history',
            'id_word'
        );

        $this->addForeignKey(
            'history_ibfk_2',
            'history',
            'id_word',
            'word',
            'id_word',
            'CASCADE'
        );

        $this->createIndex(
            'id_chosen_word',
            'history',
            'id_chosen_word'
        );

        $this->addForeignKey(
            'history_ibfk_3',
            'history',
            'id_chosen_word',
            'word',
            'id_word',
            'CASCADE'
        );
    }


    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('history');

        $this->dropForeignKey(
            'history_ibfk_1',
            'history'
        );

        $this->dropForeignKey(
            'history_ibfk_2',
            'history'
        );

        $this->dropForeignKey(
            'history_ibfk_3',
            'history'
        );

        $this->dropIndex(
            'id_challenge',
            'history'
        );

        $this->dropIndex(
            'id_word',
            'history'
        );

        $this->dropIndex(
            'id_chosen_word',
            'history'
        );
    }
}
