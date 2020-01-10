<?php
/**
 * Created by 260101081@qq.com
 * DateTime 2019-12-31 19:40
 */
namespace api\modules\v1\controllers;

use Yii;
use api\controllers\BaseCotroller;
use common\models\Properties;


class HomeController extends BaseCotroller
{
    public function actionIndex()
    {
        $data = [];

        $sql = 'SELECT
                    a.down_payment_id, a.name,
                    count( * ) AS num 
                FROM
                    ' . Properties::tableName() . ' AS a
                    INNER JOIN ' . Properties::tableName() . ' AS b ON a.down_payment_id = b.down_payment_id 
                WHERE
                    b.properties_id >= a.properties_id  AND a.down_payment_id IN (1,2,3)
                GROUP BY
                    a.properties_id 
                HAVING
                    num <= 5';
        $model = Properties::findBySql($sql)->asArray()->all();

        foreach ($model as $v)
        {
            $v['down_payment_name'] = Yii::$app->params['down_payment_name'][$v['down_payment_id']];
            $data[$v['down_payment_id']][] = $v;
        }

        response($data);
    }

}