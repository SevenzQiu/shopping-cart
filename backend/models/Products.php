<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id 產品ID
 * @property string $name 產品名稱
 * @property int $totalNum 上架數量
 * @property int $leftNum 剩餘數量
 * @property string $memo 備註
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'totalNum', 'leftNum'], 'required'],
            [['name', 'memo'], 'string'],
            [['totalNum', 'leftNum'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'totalNum' => 'Total Num',
            'leftNum' => 'Left Num',
            'memo' => 'Memo',
        ];
    }
}
