<?php

use yii\db\Migration;

class m171103_042857_queue extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%queue}}', [
            'id' => $this->primaryKey(),
            'queue_id' => $this->integer()->notNull()->comment('队列id'),
            'catalog' => $this->string()->comment('类别'),
            'name' => $this->string()->notNull()->comment('任务名称'),
            'description' => $this->text()->comment('详请信息'),
            'log' => $this->text()->comment('错误日志'),
            'exec_time' => $this->integer()->comment('执行时间'),
            'created_at' => $this->integer()->comment('队列创建时间'),
            'updated_at' => $this->integer()->comment('队列执行时间'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%queue}}');
    }
}
