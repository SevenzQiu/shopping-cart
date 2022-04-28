<?php

namespace backend\controllers;

use backend\models\ProductsSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\redis\Connection;
use yii\web\Controller;
use Yii;
use backend\models\Products;
use backend\models\Orders;


class CartController extends Controller
{
    /**
     * csrf 表單驗證
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     * redis key
     * @var string
     */
    private $redisKey;

    /**
     * redis連線
     * @var Connection
     */
    private $redis;

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
                            'actions' => ['index', 'update', 'ordering'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'update' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        // 未登入就送他去登入
        if (\Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', "還沒登入喔");
            return $this->redirect(array('site/login'));
        }

        // 組  rediskey
        $this->redisKey = 'cart:' . \Yii::$app->user->id;

        // 建立 redis 連線
        $this->redis = Yii::$app->redis;
    }

    /**
     * Lists all Orders models.
     *
     * @return string
     */
    public function actionIndex()
    {
        // 返回下單畫面
        return $this->backToIndex();
    }

    // 更新購物車
    public function actionUpdate()
    {
        // 取參數
        $request = \Yii::$app->request;

        $cartList = [];
        if ($request->post('cartList') != null) {
            $cartList = $request->post('cartList');
        }

        // 重新寫入 redis
        $this->redis = Yii::$app->redis;
        $this->redis->set($this->redisKey, json_encode($cartList));

        // 返回下單畫面
        return $this->backToIndex();
    }

    /**
     * @throws \Exception
     */
    public function actionOrdering()
    {
        // 拿當前 redis資料
        $cartData = $this->redis->get($this->redisKey) ?? json_encode([]);

        // 解包
        $cartList = json_decode($cartData);

        // 非空寫DB
        if (!empty($cartList)) {
            foreach ($cartList as $productId) {
                // 取原產品資料
                $product = Products::findOne($productId);
                // 剩餘數量 - 1
                $leftNum = $product->leftNum - 1;

                // 若剩餘數量<0 則返回下單畫面
                if ($leftNum < 0) {
                    // 返回下單畫面
                    return $this->backToIndex();
                    exit;
                }
                $product->leftNum = $leftNum;
                $product->save();
            }

            // 寫入訂單資料
            $userId = \Yii::$app->user->id;
            $orderList = $cartData;
            $time = time();

            $order = new Orders;
            $order->uid = $userId;
            $order->pList = $orderList;
            $order->placed = 'Y';
            $order->time = $time;
            $order->insert();

            // 清空 redis
            $this->redis->del($this->redisKey);
        }

        // 返回下單畫面
        return $this->backToIndex();
    }

    /**
     * 返回下單畫面
     * @return string
     */
    private function backToIndex()
    {
        // 產品列表
        $query = ProductsSearch::find();
        $products = $query->all();

        // 取購物車內容
        $cartList = $this->redis->get($this->redisKey) ?? json_encode([]);

        // 回到購物車
        return $this->render('index', [
            'products' => $products,
            'cartList' => $cartList,
        ]);
    }
}