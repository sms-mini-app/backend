<?php

use yii\db\Migration;

/**
 * Class m240613_150727_create_table_keystorage
 */
class m240613_150727_create_table_keystorage extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%key_storage}}', [
            'key' => $this->string()->notNull()->append('PRIMARY KEY'),
            'value' => $this->text()->notNull(),
            'comment' => $this->text(),
            'updated_at' => $this->integer(),
            'created_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx_key_storage_key', '{{%key_storage}}', 'key', true);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%key_storage}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240613_150727_create_table_keystorage cannot be reverted.\n";

        return false;
    }
    */
}
