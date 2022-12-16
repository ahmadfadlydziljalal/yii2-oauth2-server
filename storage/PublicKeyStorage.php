<?php
namespace app\storage;

class PublicKeyStorage implements \OAuth2\Storage\PublicKeyInterface{


   private $pbk =  null;
   private $pvk =  null;

   public function __construct()
   {

      $this->pvk =  file_get_contents(__DIR__ .'/' . 'privkey.pem', true);
      $this->pbk =  file_get_contents(__DIR__ .'/' .'pubkey.pem', true);
   }

   public function getPublicKey($client_id = null){
      return  $this->pbk;
   }

   public function getPrivateKey($client_id = null){
      return  $this->pvk;
   }

   public function getEncryptionAlgorithm($client_id = null){
      return 'RS256';
   }

}