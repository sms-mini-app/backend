<?php

use yii\db\Migration;

/**
 * Class m240613_150710_create_table_packages
 */
class m240613_150710_create_table_packages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("packages", [
            "id" => $this->primaryKey(),
            "code" => $this->string(255),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime(),
            "deleted_at" => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("packages");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240613_150710_create_table_packages cannot be reverted.\n";

        return false;
    }
    */
}
