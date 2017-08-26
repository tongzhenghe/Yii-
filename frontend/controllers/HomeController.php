<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/22
 * Time: 14:16
 */

namespace frontend\controllers;
use backend\models\Goods;
use backend\models\Goods_category;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderGoods;
use frontend\models\User;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use yii\db\Exception;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Cookie;

class HomeController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        if(\yii::$app->user->isGuest){
            echo "<a href='http://home.yiishop.com/register/login'>您还未登录请点击登录>>></a>";
        }else{
            $model = Goods_category::findAll(['parent_id' => 0]);
            return $this->render('index', ['models' => $model]);
        }
    }
//    查出一级分类
//    判断分类的层级（1级分类？2级分类？3级分类）
//    1级分类,2级分类，---》获取该分类下的所有三级分类的id  $ids=[3,5,9];
//    $cate = GoodsCategoty::findOne($categoryId);
//    深度depth，左右值(depth=2 AND lft>$cate->lft AND rgt<$cate->rgt)  获取到三级分类的id $ids=[3,5,9];
//    $models = Goods::findAll(['in','goods_category_id',$ids])// sql:   in
//    3级分类goods-category
    public function actionList($goods_category_id)
    {
        //根据当前分类id显示数据
        $cate = Goods_category::findOne($goods_category_id);
        if ($cate->depth == 2) {//根据深度判定是几级分类
            $dataObj = Goods::findAll(['goods_category_id' => $goods_category_id]);//根据分类id查询
            return $this->render('list', ['datas' => $dataObj]);
        } else {
            $cates = Goods_category::find()->where("depth=2 AND lft>$cate->lft AND rgt<$cate->rgt AND tree=$cate->tree")->all();//条
            $ids = [];
            foreach ($cates as $d) {
                $ids[] = $d->id;//通过遍历得出三级对应的id，在通过id查出当前数据
            }
            $models = Goods::find()->where(['in', 'goods_category_id', $ids])->asArray()->all();

            return $this->render('list', ['datas' => $models]);//返回视图
        }
    }

    //商品详情页
    public function actionGoods($id)
    {
        $rows = Goods::find()->where(['id' => $id])->one();
        return $this->render('goods', ['rows' => $rows]);
    }


    //2添加购物车成功提示页
    public function actionNotice($goods_id, $amount)
    {//将商品数量存入cookie中将goods_id作为建明
        //先判定是否为登陆状态（根据user组件isGet判定）如果为游客状态就把商品保存到cookie中
        if (\yii::$app->user->isGuest) {
            //实例化cookie对象从对象中获取购物车，
            $cookieObj = \yii::$app->request->cookies;
            //从cookie中获取购物车如果购物车不存在数量
            $carts = $cookieObj->getValue('carts');
            if ($carts == null) {
                //就往里面新增一条商品
                $carts = [];
                $carts[$goods_id] = $amount;
            } else {
                //如果购物车存在
                $carts = unserialize($carts);
                //在判定里面是否有商品
                if (array_key_exists($goods_id, $carts)) {
                    //如果有商品就在商品基础上累加一条
                    $carts[$goods_id] += $amount;
                } else {
                    //如果商品不存在就直接添加一条商品
                    $carts[$goods_id] = $amount;
                }
            }
            //在写入cookie中（实例化写入cookie对象=》（$app->response->cookie）
            $cookies = \yii::$app->response->cookies;
            $cookie = new Cookie([
                'name' => 'carts',
                'value' => serialize($carts),
                'expire' => time() + 30 * 24 * 3600,//保存时间天数时间戳为30天
            ]);
            $cookies->add($cookie);
            \yii::$app->session->setFlash('succcess', '添加购物车成功');
            //自动跳转到购物车
//            return $this->redirect(['home/cart']);
        } else {
            //已登陆,数据保存到数据表
            //1.根据goods_id 和 member_id 去购物车表查询，是否存在该商品
            $cart = Cart::findOne(['member_id' => \yii::$app->user->identity->getId(), 'goods_id' => $goods_id]);
            if ($cart) {
                //1.1如果已存在，则更新购物车对应的商品数量
                $cart->amount += $amount;
                $cart->save();
            } else {
                //1.2如果不存在，则插入一条新数据
                $cart = new Cart();
                $cart->goods_id = $goods_id;
                $cart->amount = $amount;
                $cart->member_id = \yii::$app->user->identity->getId();
                $cart->save();
            }
            \yii::$app->session->setFlash('succcess', '添加成功');
        }
        //自动跳转到购物车
        return $this->redirect(['home/cart']);
    }

    //购物车列表
    public function actionCart()
    {
        if (\yii::$app->user->isGuest) {
            $cookieObj = \yii::$app->request->cookies;
            //如果时游客就从cookie获取购物车
            $carts = $cookieObj->getValue('carts');
            //var_dump($carts);exit;
            if ($carts == null) {
                $carts = [];
            } else {
                $carts = unserialize($carts);
            }
            //$carts = [1=>10,3=>20];
        } else {
            $user_id = \yii::$app->user->getId();
            //获取数据库cart里面的goodsid
            $cartObj = Cart::findAll(['member_id' => $user_id]);
            $carts = [];
            foreach ($cartObj as $k => $value) {
                $carts[$value->goods_id] = $value->amount;
            }
        }
        $models = Goods::find()->where(['in', 'id', array_keys($carts)])->all();//
        //var_dump($models);exit;
        return $this->render('flow', ['models' => $models, 'carts' => $carts]);
    }

    //AJax修改商品数量
    public function actionAjax()
    {
        if (\yii::$app->user->isGuest) {
            //接受数据
            $amount = \yii::$app->request->post('amount');
            $goods_id = \Yii::$app->request->post('goods_id');
//            var_dump($goods_id,$amount);exit;
            //实例化cookie对象
            $cookieObj = \yii::$app->request->cookies;
            //看cookie购物车中是否有商品
            $carts = $cookieObj->getValue('carts');
            if ($carts == null) {
                $carts = [];
                return "商品不存在99999";
            } else {  //如果有就直接qu
                $carts = unserialize($carts);
            } //通过goodsid判定是否有该商品
            if (array_key_exists($goods_id, $carts)) {
                if ($amount == 0) {
                    //删除
                    unset($carts[$goods_id]);
                } else {
                    $carts[$goods_id] = $amount;
                }
                $cookiesObj = \yii::$app->response->cookies;
                //写入数据到cookie
                $cookie = new Cookie([
                    'name' => 'carts',
                    'value' => serialize($carts),
                    'expire' => time() + 30 * 24 * 3600 //过期时间戳 30天
                ]);
                $cookiesObj->add($cookie);//设置cookie
                return 'success';
            } else {
                return '商品不存在，请刷新页面';
            }
        } else {
            //登陆模式
            //接收数据
            $goods_id = \yii::$app->request->post('goods_id');
            $amount = \yii::$app->request->post('amount');
            //通过goods_id取出数据库里面数据
            $cartObj = Cart::findOne(['goods_id' => $goods_id]);
            //通过goods_id查看是否有该商品
            if ($cartObj) {
                if ($amount == 0) {
                    //删除
                    $cartObj->delete();
                } else {
                    //保存到数据库
                    $cartObj->amount = $amount;
                    $cartObj->save();
                    return 'success';
                }
            }
        }
    }

    public function actionDel($id)
    {
        \Yii::$app->db->createCommand()->delete('cart', ['id' => $id])->execute();
        return $this->redirect(['cart']);
    }

    //订单需求
    public function actionOrder()
    {
        if (\yii::$app->request->isPost) {
            //开启事务
            $transaction = \yii::$app->db->beginTransaction();
            try {
                //实例化订单对象
                $orderObj = new Order();
                //填写地址信息
                $id = \yii::$app->request->post('address_id');
                $address = Address::findOne(['id' => $id]);
                $orderObj->name = $address->consignee;//收货人detailedAddress
                $orderObj->tel = $address->tel;  //电话。
                $orderObj->province = $address->town;//市
                $orderObj->city = $address->district;//区县
                $orderObj->area = $address->place;//地方
                $orderObj->address = $address->detailedAddress;//详细地址
                $orderObj->create_time = time();//详细地址
                //var_dump($orderObj->address);exit;
                //送货方式
                $delivery_id = \yii::$app->request->post('delivery_id');
                $orderObj->delivery_id = $delivery_id;
                $orderObj->delivery_name = Order::$deliveries[$orderObj->delivery_id][0];//快递方式\
                $orderObj->total = Order::$deliveries[$orderObj->delivery_id][1];//价格
                //支付方式
                $payment_id = \yii::$app->request->post('payment_id');
                $orderObj->payment_id = $payment_id;
                $orderObj->payment_name = Order::$orders[$orderObj->payment_id][0];
                if ($orderObj->validate()) {
                    //保存订单
                    $orderObj->save();
                } else {
                    //提示错误信息
                    var_dump($orderObj->getErrors());
                    exit;
                }
                //依次检查购物车的商品库存
                //得到商品数量
                $cart = Cart::findAll(['member_id' => \yii::$app->user->getId()]);
                //遍历
                foreach ($cart as $key => $val) {
                    //检查该商品库存是否足够 $cart=[goods_id=>1,amount=>22];
                    //获取商品表中对应商品的库存
                    $goods = Goods::findOne(['id' => $val->goods_id]);
                    if ($goods['stock'] < $val->amount) {
                        //抛出异常
                        throw new Exception('商品库存不足，请返回购物车修改');
                    }//判定库存
                    //库存足够，扣减库存，生成订单商品详情数据
                    // 创建订单详情表记录
                    $orderGoods = new OrderGoods();//商品库存
                    $orderGoods->goods_name = $goods['name'];
                    $orderGoods->price_decimal = $goods['shop_price'];
                    $orderGoods->amount = $goods['stock'];
                    $orderGoods->save();
                    //跳转页面
                    \yii::$app->session->setFlash('success','提交成功');
                    //扣减库存
                    Goods::updateAllCounters(['stock' => -$orderGoods->amount], ['goods_id' => $orderGoods->goods_id]);
                    return $this->redirect(['show']);
                    //获取购物车提交的用户订单信息：订单号(id)	订单商品（goods_id）	收货人（member_id）	订单金额(goods_id和amount)	下单时间（本表创建时间）	订单状态（订单状态（0已取消1待付款2待发货3待收货4完成）操作
                    //显示列表
                }
                //写入订单表
                //展示订单列表
                //提交事务
                $transaction->commit();
                //跳转到订单提交成功页面
            } catch (Exception $e) {
                //如果不够回滚
                $transaction->rollBack();
            }
        }
        $cartsObj = Cart::findAll(['member_id' => \yii::$app->user->identity->getId()]);
        foreach ($cartsObj as $k => $v) {
            $carts[$v->goods_id] = $v->amount;
            //收获人
            $addressObj = Address::findAll(['member_id' => \yii::$app->user->getId()]);
            //查商品
            $models = Goods::find()->where(['in', 'id', array_keys($carts)])->all();
            return $this->render('order', ['goods' => $models, 'address' => $addressObj]);
        }
    }


public function actionShow(){
    $QueryObj = new \yii\db\Query();
    $datas = $QueryObj->select(['order.create_time', 'order.id', 'order_goods.logo', 'order_goods.goods_name', 'order.name', 'order.total', 'order.status'])
        ->from('order')
        ->innerJoin('order_goods')
        ->all();
    return $this->render('ordertow', ['datas' => $datas]);
   }
}