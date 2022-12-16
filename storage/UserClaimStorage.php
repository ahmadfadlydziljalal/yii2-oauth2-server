<?php

namespace app\storage;

use app\models\User;
use OAuth2\OpenID\Storage\UserClaimsInterface;

class UserClaimStorage implements UserClaimsInterface
{

   private $pbk =  null;
   private $pvk =  null;

   public function __construct()
   {
      $this->pvk =  file_get_contents(__DIR__ .'/' . 'privkey.pem', true);
      $this->pbk =  file_get_contents(__DIR__ .'/' .'pubkey.pem', true);
   }
   public function getUserClaims($user_id, $scope)
   {
     $user = User::findOne($user_id);
     return [
       'user' => [
          'id' => $user->id,
          'username' => $user->username,
          'email' => $user->email,
       ]
     ];
   }
}