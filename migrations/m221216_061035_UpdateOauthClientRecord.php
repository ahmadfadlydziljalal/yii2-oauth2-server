<?php

use yii\db\Migration;

/**
 * Class m221216_061035_UpdateOauthClientRecord
 */
class m221216_061035_UpdateOauthClientRecord extends Migration
{

   private string $table = "{{%oauth_clients}}";

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->update($this->table, ['redirect_uri' => 'http://localhost:8081/authorize?authclient=my-oauth2'],
         [
            'client_id' => 'testclient'
         ]
      );
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      return true;
   }

   /*
   // Use up()/down() to run migration code without a transaction.
   public function up()
   {

   }

   public function down()
   {
       echo "m221216_061035_UpdateOauthClientRecord cannot be reverted.\n";

       return false;
   }
   */
}