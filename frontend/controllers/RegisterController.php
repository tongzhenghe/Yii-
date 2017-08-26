<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/21
 * Time: 12:06
 */

namespace frontend\controllers;


use frontend\models\Cart;
use frontend\models\Login;
use frontend\models\Member;
use yii\web\Controller;
use yii;
    class RegisterController extends Controller
{
    public $enableCsrfValidation = false;//接受表单省去前缀
    //注册    register/reg
    public function actionReg(){
        //实例化模型
        $model = new Member();
        if(yii::$app->request->isPost){
            if($model->load(yii::$app->request->post(),'')){
                if($model->validate()){
                    //验证输入密码一致
                    if($_POST['repassword']===$_POST['password']){//
                        $model->auth_key = 'frfhudsf';
                        //为密码加密
                        $model->password_hash = yii::$app->security->generatePasswordHash($model->password);
                        if($model->save()){
                            echo "注册成功";exit;
                        }
                    }else{
                        echo "密码不一致";exit;
                    }
                }
            }
        }
        return $this->render('regist');
    }
    //登陆
    public function actionLogin(){
        //接受数据
        $model = new Login();
//        $member = new Member();
        if($model->load(yii::$app->request->post(),'')){
            //验证数据
            if($model->validate()){
                //验证用户名和数据库的用户名比对（身份验证）
                $info = Member::findOne(['username'=>$model->username]);
                if($info){//如果用户名存在
                    //明文密码和数据库hash密码比对
                    if(yii::$app->security->validatePassword($model->password,$info->password_hash)){
                        if(isset($_POST['member'])){
                            $_POST['member'] = 7*24*3600;
                        }else{
                            $_POST['member'] = 0;
                        }
                        $member = $_POST['member'];
//                        if(yii::$app->user->isGuest){
//                        echo "你是游客请登录";
//                    }else{
                        //通过user组件登陆保存到session
                            if(yii::$app->user->login($info,$member)){
                                $info->last_login_ip = yii::$app->request->userIP;
                                $info->last_login_time = date('Y-m-d H:m:s',time());
                                //清除COOKie里面的商品
                                $info->save(false);
//                        ---------------------同步cookie中的购物车数据到数据库--------------------
                                $this->XXXX();
//                        ---------------------同步cookie中的购物车数据到数据库--------------------
//                        -----------------同步到数据库完成，清除cookie----------------

//                        -----------------同步到数据库完成，清除cookie----------------
//                                var_dump(\yii::$app->user->identity->id);exit;
                                return $this->redirect(['home/index']);
                            }
//                        }
                        //提示信息
                    }else{
                      echo"密码有误";
                    }
                }else{
                   echo "用户名有误";exit;
                }
                //自动登录
                //提示信息
            }else{
               echo "验证失败";exit;
            }
        }
        //显示表单
      return $this->render('login');
    }
        public function actionLogout()
        {
            Yii::$app->user->logout();
            return $this->redirect(['login']);
    }

//同步cookie到数据库
    public function XXXX()
    {
        $member_id = Yii::$app->user->identity->id;
        $carts = unserialize(Yii::$app->request->cookies->getValue('carts'));
//        var_dump($carts);exit;
        if ($carts) {//有数据的情况才处理
            foreach ($carts as $k => $v) {
                $cartObj = Cart::findOne(['goods_id' => $k, 'member_id' => $member_id]);
                if ($cartObj) {
                    $cartObj->amount += $v;
                } else {
                    $cartObj = new Cart();
                    $cartObj->goods_id = $k;
                    $cartObj->amount = $v;
                    $cartObj->member_id = $member_id;
                }
                    $cartObj->save();
                    $cookie = Yii::$app->response->cookies;
                    $cookie->remove('carts');
            }
        }
    }


}