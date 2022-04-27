<?php

namespace backend\controllers;

use yii\rest\ActiveController;
use Yii;

class CartController extends ActiveController
{
    public $modelClass = 'app\models\Cart';
}