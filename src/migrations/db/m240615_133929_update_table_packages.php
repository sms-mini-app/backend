<?php

use yii\db\Migration;

/**
 * Class m240615_133929_update_table_packages
 */
class m240615_133929_update_table_packages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("packages", "price", $this->float()->after("created_at"));
        $this->addColumn("packages", "use_duration", $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("packages", "price");
        $this->dropColumn("packages", "use_duration");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240615_133929_update_table_packages cannot be reverted.\n";

        return false;
    }
    */
}
