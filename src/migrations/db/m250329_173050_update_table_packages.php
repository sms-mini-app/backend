<?php

use yii\db\Migration;

/**
 * Class m250329_173050_update_table_packages
 */
class m250329_173050_update_table_packages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("packages", "type", $this->integer()->after("name"));
        $this->addColumn("packages", "status", $this->integer()->after("name")->defaultValue(1));
        $this->addColumn("packages", "description_attributes", $this->json()->after("name"));
        $this->addColumn("packages", "priority", $this->integer()->defaultValue(0)->after("name"));
        $this->addColumn("packages", "subtitle", $this->string()->after("name"));
        $this->addColumn("packages", "price_text", $this->string()->after("name"));
        $this->addColumn("packages", "qr_link", $this->string()->after("name"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("packages", "type");
        $this->dropColumn("packages", "status");
        $this->dropColumn("packages", "description_attributes");
        $this->dropColumn("packages", "priority");
        $this->dropColumn("packages", "subtitle");
        $this->dropColumn("packages", "price_text");
        $this->dropColumn("packages", "qr_link");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250329_173050_update_table_packages cannot be reverted.\n";

        return false;
    }
    */
}
