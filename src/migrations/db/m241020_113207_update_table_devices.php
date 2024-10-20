<?php

use yii\db\Migration;

/**
 * Class m241020_113207_update_table_devices
 */
class m241020_113207_update_table_devices extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("devices", "version_level", $this->integer());
        $this->createIndex("idx-devices-version_level", "devices", "version_level");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("devices", "version_id");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241020_113207_update_table_devices cannot be reverted.\n";

        return false;
    }
    */
}
