<?php

namespace backend\models;

use yii\redis\ActiveQuery;

class CartQuery
{
    /**
     * Define a modified range of ` $query 'and return valid (status = 1) customers.
     */
    public function active()
    {
        return $this->andWhere(['status' => 1]);
    }

}