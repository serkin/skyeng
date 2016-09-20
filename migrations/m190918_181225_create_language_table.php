<?php

use yii\db\Migration;

/**
 * Handles the creation for table `language`.
 */
class m190918_181225_create_language_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('language', [
            'id_language' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->insert('language', [
            'id_language' => 1,
            'name' => 'Russian',
        ]);

        $this->insert('language', [
            'id_language' => 2,
            'name' => 'English',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('language');
    }
}
