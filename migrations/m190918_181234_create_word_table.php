<?php

use yii\db\Migration;

/**
 * Handles the creation for table `word`.
 */
class m190918_181234_create_word_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('word', [
            'id_word' => $this->primaryKey(),
            'id_language' => $this->integer()->notNull(),
            'word' => $this->string()->notNull()
        ]);


        $this->createIndex(
            'id_language',
            'word',
            'id_language'
        );


        $this->addForeignKey(
            'word_ibfk_1',
            'word',
            'id_language',
            'language',
            'id_language',
            'CASCADE'
        );
        

    }


    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('word');

        $this->dropForeignKey(
            'word_ibfk_1',
            'word'
        );

        $this->dropIndex(
            'id_language',
            'word'
        );
    }
}
