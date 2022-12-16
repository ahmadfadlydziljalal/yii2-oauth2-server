<?php

namespace app\controllers;

use app\components\Controller as ComponentsController;
use app\models\LoginForm;
use filsh\yii2\oauth2server\Server;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

class SiteController extends ComponentsController
{

   /**
    * {@inheritdoc}
    */
   public function behaviors(): array
   {
      return [
         'access' => [
            'class' => AccessControl::class,
            'only' => ['logout'],
            'rules' => [
               [
                  'actions' => ['logout'],
                  'allow' => true,
                  'roles' => ['@'],
               ],
            ],
         ],
         'verbs' => [
            'class' => VerbFilter::class,
            'actions' => [
               'logout' => ['post'],
            ],
         ],
      ];
   }

   /**
    * {@inheritdoc}
    */
   public function actions(): array
   {
      return [
         'error' => [
            'class' => 'yii\web\ErrorAction',
         ],
         'captcha' => [
            'class' => 'yii\captcha\CaptchaAction',
            'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
         ],
      ];
   }

   /**
    * Displays homepage.
    *
    * @return string
    */
   public function actionIndex(): string
   {
      return $this->render('index');
   }

   /**
    * @return string|Response
    */
   public function actionLogin()
   {
      if (!Yii::$app->user->isGuest) {
         return $this->goHome();
      }

      $model = new LoginForm();
      if ($model->load(Yii::$app->request->post()) && $model->login()) {
         return $this->goBack();
      }

      $model->password = '';
      return $this->render('login', [
         'model' => $model,
      ]);
   }

   /**
    * @return Response | string
    */
   public function actionAuthorize()
   {
      if (Yii::$app->user->isGuest) {
         Yii::$app->user->returnUrl = Yii::$app->request->url;
         return $this->redirect('login');
      }

      /** @var $response Server */
      $server = Yii::$app->getModule('oauth2')->getServer();
      $authorizeRequest = $server->handleAuthorizeRequest(
         null,
         null,
         !Yii::$app->user->isGuest,
         Yii::$app->user->id
      );

      /** @var object $response \OAuth2\Response */
      Yii::$app->response->format = Response::FORMAT_JSON;
      $location = $authorizeRequest->getHttpHeaders()['Location'];

      return $this->redirect($location);

   }

   /**
    * Logout action.
    *
    * @return Response
    */
   public function actionLogout(): Response
   {
      Yii::$app->user->logout();
      return $this->goHome();
   }
}