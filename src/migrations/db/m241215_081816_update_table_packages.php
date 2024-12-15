<?php

use yii\db\Migration;

/**
 * Class m241215_081816_update_table_packages
 */
class m241215_081816_update_table_packages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("packages", "name", $this->string()->after("code"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("packages", "name");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241215_081816_update_table_packages cannot be reverted.\n";

        return false;
    }
    */
}
