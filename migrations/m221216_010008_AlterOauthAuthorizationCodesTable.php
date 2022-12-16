<?php

use yii\db\Migration;

/**
 * Class m221216_010008_AlterOauthAuthorizationCodesTable
 */
class m221216_010008_AlterOauthAuthorizationCodesTable extends Migration
{

   private string $table = "{{%oauth_authorization_codes}}";

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {


      // ALTER TABLE oauth_authorization_codes ADD id_token VARCHAR(1000) NULL DEFAULT NULL;
      $this->addColumn(
         $this->table,
         'id_token',
         $this->string(1000)->null()->defaultValue('NULL')
      );
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropColumn(
         $this->table,
         'id_token'
      );
   }

   /*
   // Use up()/down() to run migration code without a transaction.
   public function up()
   {

   }

   public function down()
   {
       echo "m221216_010008_AlterOauthAuthorizationCodesTable cannot be reverted.\n";

       return false;
   }
   */
}