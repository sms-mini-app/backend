<?php

use yii\db\Migration;

/**
 * Class m240613_150651_create_table_devices
 */
class m240613_150651_create_table_devices extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("devices", [
            "id" => $this->primaryKey(),
            "tenant_id" => $this->string(255),
            "device_uuid_hash" => $this->string(500),
            "info" => $this->json(),
            "logged_at" => $this->dateTime(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ]);

        $this->createIndex("idx-devices-tenant_id", "devices", "tenant_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("devices");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240613_150651_create_table_devices cannot be reverted.\n";

        return false;
    }
    */
}
