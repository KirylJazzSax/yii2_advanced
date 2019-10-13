<?php

use yii\db\Migration;

/**
 * Class m191001_221418_addFieldDescription
 */
class m191001_221418_addFieldDescription extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'description');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191001_221418_addFieldDescription cannot be reverted.\n";

        return false;
    }
    */
}
