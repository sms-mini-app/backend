<?php

use yii\db\Migration;

/**
 * Class m250127_150000_create_table_device_services
 */
class m250127_150000_create_table_device_services extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("device_services", [
            "id" => $this->primaryKey(),
            "device_id" => $this->integer(),
            "service_id" => $this->integer(),
            "token" => $this->string(255),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ]);

        $this->createIndex("idx-device_services-device_id", "device_services", "device_id");
        $this->createIndex("idx-device-services-service_id", "device_services", "service_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("device_services");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250127_150000_create_table_device_services cannot be reverted.\n";

        return false;
    }
    */
}
