<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use backend\models\Orders;
use backend\models\Products;
use backend\models\ProductsSearch;

/* @var $this yii\web\View */
/* @var $orders backend\models\Orders */
/* @var $products backend\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <form action="/backend/web/index.php/?r=orders/addcart" method="post">
        <table class="table table-hover ">
            <thead>
            <tr>
                <th>#</th>
                <th>名稱</th>
                <th>剩餘</th>
                <th>加入購物車</th> <!-- 空欄位放checkbox -->
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?=$product->id?></td>
                    <td><?=$product->name?></td>
                    <td><?=$product->leftNum?></td>
                    <td><input type="checkbox" name="cartList[]" value="<?=$product->id?>"></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">提交</button>
    </form>



</div>
