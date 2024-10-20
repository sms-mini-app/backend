<?php

use yii\db\Migration;

/**
 * Class m241020_113155_create_table_apps
 */
class m241020_113155_create_table_apps extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("apps", [
            "id" => $this->primaryKey(),
            "version" => $this->string(),
            "version_level" => $this->integer(),
            "required_update" => $this->boolean(),
            "description_upgrade" => $this->text(),
            "link" => $this->string(255),
            "status" => $this->boolean(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("apps");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241020_113155_create_table_apps cannot be reverted.\n";

        return false;
    }
    */
}
