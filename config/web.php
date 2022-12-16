<?php

use app\models\User;
use app\storage\PublicKeyStorage;
use app\storage\UserClaimStorage;
use filsh\yii2\oauth2server\Request;
use filsh\yii2\oauth2server\Response;
use OAuth2\GrantType\ClientCredentials;
use OAuth2\GrantType\RefreshToken;
use OAuth2\GrantType\UserCredentials;
use OAuth2\OpenID\GrantType\AuthorizationCode;
use OAuth2\Storage\JwtAccessToken;
use yii\symfonymailer\Mailer;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
   'id' => 'basic',
   'name' => 'Yii2 Oauth2 Server',
   'basePath' => dirname(__DIR__),
   'bootstrap' => ['log', 'oauth2'],
   'aliases' => [
      '@bower' => '@vendor/bower-asset',
      '@npm' => '@vendor/npm-asset',
   ],
   'components' => [
      'i18n' => [
         'translations' => [
            '*' => [
               'class' => 'yii\i18n\PhpMessageSource',
               'basePath' => '@app/messages', // if advanced application, set @frontend/messages
               'sourceLanguage' => 'en',
               'fileMap' => [
                  //'main' => 'main.php',
               ],
            ],
         ],
      ],
      'authManager' => [
         'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
      ],
      'request' => [
         // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
         'cookieValidationKey' => 'A0-Dqz-RDhG78qolcuNfGrdSH8kQcwFz',
      ],
      'cache' => [
         'class' => 'yii\caching\FileCache',
      ],
      'user' => [
         'identityClass' => User::class,
         'enableAutoLogin' => true,
      ],
      'errorHandler' => [
         'errorAction' => 'site/error',
      ],
      'mailer' => [
         'class' => Mailer::class,
         'viewPath' => '@app/mail',
         // send all mails to a file by default.
         'useFileTransport' => true,
      ],
      'log' => [
         'traceLevel' => YII_DEBUG ? 3 : 0,
         'targets' => [
            [
               'class' => 'yii\log\FileTarget',
               'levels' => ['error', 'warning'],
            ],
         ],
      ],
      'db' => $db,
      'urlManager' => [
         'enablePrettyUrl' => true,
         'showScriptName' => false,
         'rules' => [
            '<alias:\w+>' => 'site/<alias>',
            'GET oauth2/user-info' => 'oauth2/rest/user-info',
            'POST oauth2/<action:\w+>' => 'oauth2/rest/<action>',
         ]
      ],
   ],
   'modules' => [
      'oauth2' => [
         'class' => 'filsh\yii2\oauth2server\Module',
         'useJwtToken' => true,
         'components' => [
            'request' => function () {
               return Request::createFromGlobals();
            },
            'response' => [
               'class' => Response::class,
            ],
         ],
         'tokenParamName' => 'accessToken',
         'tokenAccessLifetime' => 3600 * 24,
         'storageMap' => [
            'user_credentials' => User::class,
            'public_key' => PublicKeyStorage::class,
            'access_token' => JwtAccessToken::class,
            'user_claims' => UserClaimStorage::class,
         ],
         'grantTypes' => [
            'authorization_code' => [
               'class' => AuthorizationCode::class
            ],
            'user_credentials' => [
               'class' => UserCredentials::class
            ],
            'client_credentials' => [
               'class' => ClientCredentials::class
            ],
            'refresh_token' => [
               'class' => RefreshToken::class,
               'always_issue_new_refresh_token' => true
            ]
         ],
         'options' => [
            'allow_implicit' => true,
            'use_openid_connect' => true,
            'issuer' => 'Authorization Server',
            #'use_jwt_access_tokens' => false,
            #'jwt_extra_payload_callable' => null,
            #'store_encrypted_token_string' => true,
            #'id_lifetime' => 3600,
            #'access_lifetime' => 86400,
            #'www_realm' => 'Service',
            #'token_param_name' => 'accessToken',
            #'token_bearer_header_name' => 'Bearer',
            #'enforce_state' => true,
            #'require_exact_redirect_uri' => true,
            #'allow_credentials_in_request_body' => true,
            #'allow_public_clients' => true,
            #'always_issue_new_refresh_token'=> false,
            #'unset_refresh_token_after_use' => true,*/
         ]
      ],
      'admin' => ['class' => 'mdm\admin\Module',],
   ],
   'as access' => [
      'class' => 'mdm\admin\components\AccessControl',
      'allowActions' => [
         'site/*',
         'admin/user/signup',
         'oauth2/*'
         // The actions listed here will be allowed to everyone including guests.
         // So, 'admin/*' should not appear here in the production, of course.
         // But in the earlier stages of your development, you may probably want to
         // add a lot of actions here until you finally completed setting up rbac,
         // otherwise you may not even take a first step.
      ]
   ],
   'params' => $params,
];

if (YII_ENV_DEV) {
   // configuration adjustments for 'dev' environment
   $config['bootstrap'][] = 'debug';
   $config['modules']['debug'] = [
      'class' => 'yii\debug\Module',
      // uncomment the following to add your IP if you are not connecting from localhost.
      'allowedIPs' => ["*"],
   ];

   $config['bootstrap'][] = 'gii';
   $config['modules']['gii'] = [
      'class' => 'yii\gii\Module',
      // uncomment the following to add your IP if you are not connecting from localhost.
      //'allowedIPs' => ['127.0.0.1', '::1'],
   ];
}

return $config;