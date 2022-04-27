<?php

namespace backend\models;

use yii\redis\ActiveQuery;
use yii\redis\ActiveRecord;

class Cart extends ActiveRecord
{
    /**
     * @return array List of properties for this record
     */
    public function attributes()
    {
        return ['id', 'name', 'address', 'registration_date'];
    }

    /**
     * @return ActiveQuery Define a record associated with Order (it can be in other databases, such as elastic search or sql)
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['customer_id' => 'id']);
    }

    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }
}