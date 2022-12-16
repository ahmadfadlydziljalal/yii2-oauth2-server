<?php

namespace app\models;

use OAuth2\Storage\UserCredentialsInterface;

class User extends \mdm\admin\models\User implements UserCredentialsInterface
{

    public function checkUserCredentials($username, $password)
    {
        $user = static::findByUsername($username);
        if (empty($user)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    public function getUserDetails($username)
    {
        $user = static::findByUsername($username);
        return [
           'user_id' => $user->getId(),
           'scope' => null
        ];
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
       /** @var \filsh\yii2\oauth2server\Module $module */
       $module = Yii::$app->getModule('oauth2');
       $token = $module->getServer()->getResourceController()->getToken();
       return !empty($token['user_id'])
          ? static::findIdentity($token['user_id'])
          : null;
    }

}