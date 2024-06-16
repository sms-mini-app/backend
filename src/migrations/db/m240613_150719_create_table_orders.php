<?php

use yii\db\Migration;

/**
 * Class m240613_150719_create_table_orders
 */
class m240613_150719_create_table_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("orders", [
            "id" => $this->primaryKey(),
            "device_id" => $this->integer(),
            "package_id" => $this->integer(),
            "status" => $this->integer(),
            "expired_at" => $this->dateTime(),
            "type" => $this->string(100),
            "provider_code" => $this->string(50),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ]);

        $this->createIndex("idx-orders-device_id", "orders", "device_id");

        $this->createIndex("idx-orders-package_id", "orders", "package_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("orders");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240613_150719_create_table_orders cannot be reverted.\n";

        return false;
    }
    */
}
