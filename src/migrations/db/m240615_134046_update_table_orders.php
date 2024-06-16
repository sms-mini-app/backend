<?php

use yii\db\Migration;

/**
 * Class m240615_134046_update_table_orders
 */
class m240615_134046_update_table_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("orders", "provider_note", $this->text()->after("created_at"));
        $this->addColumn("orders", "price", $this->double()->after("created_at"));
        $this->addColumn("orders", "customer", $this->string(255)->after("created_at"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("orders", "provider_note");
        $this->dropColumn("orders", "price");
        $this->dropColumn("orders", "customer");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240615_134046_update_table_orders cannot be reverted.\n";

        return false;
    }
    */
}
