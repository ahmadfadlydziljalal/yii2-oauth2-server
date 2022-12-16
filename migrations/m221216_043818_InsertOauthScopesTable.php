<?php

use yii\db\Migration;

/**
 * Class m221216_043818_InsertOauthScopesTable
 */
class m221216_043818_InsertOauthScopesTable extends Migration
{


   private string $table = "{{%oauth_scopes}}";

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->batchInsert($this->table, ['scope', 'is_default'], [
         ['id', 1],
         ['username', 1],
         ['email', 1],
         ['openid', 1],
      ]);
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      echo "m221216_043818_InsertOauthScopesTable cannot be reverted.\n";

      return false;
   }

   /*
   // Use up()/down() to run migration code without a transaction.
   public function up()
   {

   }

   public function down()
   {
       echo "m221216_043818_InsertOauthScopesTable cannot be reverted.\n";

       return false;
   }
   */
}