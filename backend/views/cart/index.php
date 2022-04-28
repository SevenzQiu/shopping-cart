<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use backend\models\Products;

/* @var $this yii\web\View */
/* @var $products backend\models\ProductsSearch */
/* @var $cartList \yii\helpers\Json */

$this->title = 'cart';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <form action="/backend/web/index.php/?r=cart/update" method="post">
        <table class="table table-hover ">
            <thead>
            <tr>
                <th>#</th>
                <th>名稱</th>
                <th>剩餘</th>
                <th></th> <!-- 空欄位放checkbox -->
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
            <?php
                $cart = json_decode($cartList);
                if (!in_array($product->id, $cart)) {
                    continue;
                }
            ?>
                <tr>
                    <td><?=$product->id?></td>
                    <td><?=$product->name?></td>
                    <td><?=$product->leftNum?></td>
                    <td><input type="checkbox" name="cartList[]" value="<?=$product->id?>" checked></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">更新購物車</button>
    </form>

    <a href="/backend/web/index.php/?r=cart/ordering" target="_parent"><button class="btn btn-success">下單</button></a>

</div>
