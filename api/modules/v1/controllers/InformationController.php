<?php
/**
 * Created by 260101081@qq.com
 * DateTime 2020-01-05 09:47
 */

namespace api\modules\v1\controllers;


use Yii;
use api\controllers\BaseController;
use common\models\PropertiesInformation;
use yii\filters\auth\HttpBearerAuth;

class InformationController extends BaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors(); // TODO: Change the autogenerated stub

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'optional' => [
                'info',
                'index',
            ], //不用授权方法
        ];

        return $behaviors;
    }

    /**
     * 楼盘资讯列表
     * @return array
     */
    public function actionIndex()
    {
        $data = [];
        $propertiesId = Yii::$app->request->get('properties_id', 0);
        $page = Yii::$app->request->get('page', 1);
        $offset = ($page - 1) * Yii::$app->params['pageSize'];

        $model = PropertiesInformation::find()
            ->select(['properties_information_id', 'title', 'create_time', 'pic'])
            ->where(['properties_id' => $propertiesId])
            ->offset($offset)
            ->limit(Yii::$app->params['pageSize'])
            ->asArray()
            ->all();

        foreach ($model as $k => $v)
        {
            $v['create_time'] = date('n-d H:i:s', $v['create_time']);
            $data[$k] = $v;
        }

        return response($data);
    }

    /**
     * 获取楼盘资讯详情
     * @return array
     */
    public function actionInfo()
    {
        $informationId = Yii::$app->request->get('properties_information_id', 0);
        $model = PropertiesInformation::find()
            ->where(['properties_information_id' => $informationId])
            ->asArray()
            ->one();

        if ($model)
        {
            $model['create_time'] = date('Y.m.d H:i:s');
        }

        return response($model);
    }
}
