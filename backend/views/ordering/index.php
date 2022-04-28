<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use backend\models\Orders;
use backend\models\Products;
use backend\models\ProductsSearch;

/* @var $this yii\web\View */
/* @var $orderData \yii\helpers\Json */

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
                <th>商品</th>
                <th>下單時間</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orderData as $order): ?>
                <tr>
                    <td><?=$order['id']?></td>
                    <td>
                    <?php foreach ($order['pList'] as $p): ?>
                        <?= $p . ' '?>
                    <?php endforeach;?>
                    </td>
                    <td><?=$order['time']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </form>
</div>
