<?php

use yii\db\Migration;

/**
 * Handles the creation for table `translation`.
 */
class m190918_181334_create_translation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('translation', [
            'id_word1' => $this->integer()->notNull(),
            'id_word2' => $this->integer()->notNull(),
            'UNIQUE KEY unique_w1w2(id_word1, id_word2)',
        ]);

        $this->createIndex(
            'id_word1',
            'translation',
            'id_word2'
        );

        $this->addForeignKey(
            'translation_ibfk_1',
            'translation',
            'id_word1',
            'word',
            'id_word',
            'CASCADE'
        );

        $this->createIndex(
            'id_word2',
            'translation',
            'id_word2'
        );

        $this->addForeignKey(
            'translation_ibfk_2',
            'translation',
            'id_word2',
            'word',
            'id_word',
            'CASCADE'
        );
        
        $arr = [
            ['apple', "яблоко"],
            ['peach', "персик"],
            ['orange', "апельсин"],
            ['grape', "виноград"],
            ['lemon', "лимон"],
            ['pineapple', "ананас"],
            ['watermelon', "арбуз"],
            ['coconut', "кокос"],
            ['banana', "банан"],
            ['pomelo', "помело"],
            ['strawberry', "клубника"],
            ['raspberry', "малина"],
            ['melon', "дыня"],
            ['apricot', "абрикос"],
            ['mango', "манго"],
            ['pear', "слива"],
            ['pomegranate', "гранат"],
            ['cherry', "вишня"]
        ];

        $key = 0;


        foreach ($arr as $word) {

            list($enWord, $ruWord) = $word;

            $ruWordKey = ++$key;
            $enWordKey = ++$key;

            $this->insert('word', [
                'id_word' => $ruWordKey,
                'id_language' => 1,
                'word' => $ruWord
            ]);

            $this->insert('word', [
                'id_word' => $enWordKey,
                'id_language' => 2,
                'word' => $enWord
            ]);

            $this->insert('translation', [
                'id_word1' => $enWordKey,
                'id_word2' => $ruWordKey,
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('translation');

        $this->dropForeignKey(
            'translation_ibfk_1',
            'translation'
        );

        $this->dropForeignKey(
            'translation_ibfk_2',
            'translation'
        );

        $this->dropIndex(
            'id_word1',
            'translation'
        );

        $this->dropIndex(
            'id_word2',
            'translation'
        );
    }
}
