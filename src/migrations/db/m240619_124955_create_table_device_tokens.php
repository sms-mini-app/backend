<?php

use yii\db\Migration;

/**
 * Class m240619_124955_create_table_device_tokens
 */
class m240619_124955_create_table_device_tokens extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('device_tokens', [
            'id' => $this->primaryKey(),
            'device_id' => $this->integer()->notNull(),
            'type' => $this->string()->notNull(),
            'token' => $this->string(40)->notNull(),
            'expire_at' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);
        $this->createIndex("idx-device_tokens-device_id", "device_tokens", "device_id");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("device_tokens");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240619_124955_create_table_device_tokens cannot be reverted.\n";

        return false;
    }
    */
}
