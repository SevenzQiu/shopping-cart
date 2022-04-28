<?php

namespace backend\controllers;

use backend\models\ProductsSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\models\Orders;
use backend\models\OrderSearch;

class OrderingController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [],
                ],
            ]
        );
    }
    /**
     * Lists all Orders models.
     *
     * @return string
     */
    public function actionIndex()
    {
        // 未登入就送他去登入
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('site/login'));
        }

        // 產品列表
        $query = ProductsSearch::find();
        $productList = $query->all();
        $prodectData = [];
        foreach ($productList as $products) {
            $prodectData[] = $products->toArray();
        }

        // 訂單列表
        $orderSearch = new OrderSearch();
        $data = $orderSearch->getSearchDESC(\Yii::$app->user->id);
        $orderList = $data->getModels();
        $orderData = [];
        foreach ($orderList as $orders) {
            // 找出產品name
            $pData = [];
            $pList = json_decode($orders->pList);
            foreach ($pList as $p) {
                $pData[] = $prodectData[$p - 1]['name'];
            }

            $orderData[] = [
                'id' => $orders->id,
                'pList' => $pData,
                'time' => date('Y-m-d H:i:s', $orders->time),
            ];
        }

        return $this->render('index', [
            'orderData' => $orderData,
        ]);
    }
}