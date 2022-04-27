<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id 訂單ID
 * @property int $uid 會員ID
 * @property string $pList 訂單列表(json)
 * @property string $placed 訂單成立與否(預設Ｎ)
 * @property int $time 訂單時間(time格式)
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'pList', 'time'], 'required'],
            [['uid', 'time'], 'integer'],
            [['pList'], 'string'],
            [['placed'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'pList' => 'P List',
            'placed' => 'Placed',
            'time' => 'Time',
        ];
    }
}
