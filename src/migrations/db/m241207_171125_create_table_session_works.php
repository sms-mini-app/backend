<?php

use yii\db\Migration;

/**
 * Class m241207_171125_create_table_session_works
 */
class m241207_171125_create_table_session_works extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("session_works", [
            "id" => $this->primaryKey(),
            "created_by" => $this->integer(),
            "report" => $this->json(),
            "filename" => $this->string(500),
            "data" => "LONGTEXT",
            "select_data" => "LONGTEXT",
            "is_session_current" => $this->boolean(),
            "type" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ]);

        $this->createIndex("idx-session_works-created_by", "session_works", "created_by");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("session_works");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241207_171125_create_table_session_works cannot be reverted.\n";

        return false;
    }
    */
}
