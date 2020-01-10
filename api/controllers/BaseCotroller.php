<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/8
 * Time: 2:20
 */

namespace api\controllers;

use api\models\User;
use yii\rest\ActiveController;
use \yii\filters\auth\HttpBearerAuth;

class BaseCotroller extends ActiveController
{
    public $modelClass = 'api\models\User';

    /*public function actions() {
        $actions = parent::actions();
        unset($actions['index'],$actions['delete'],$actions['update'], $actions['create'], $actions['view'], $actions['options']);
        return $actions;
    }*/

    public $_user;
    public $_userId;



    /**
     * 登录授权
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors(); // TODO: Change the autogenerated stub

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'optional' => ['login','logout','signup'], //不用授权方法
        ];

        return $behaviors;
    }

}