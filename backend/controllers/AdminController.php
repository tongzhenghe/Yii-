<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/16
 * Time: 11:36
 */

namespace backend\controllers;


use backend\models\Admin;
use backend\models\Changepass;
use backend\models\Login;
use backend\rbacfilter\RbacFilter;
use yii\web\Controller;
use yii;
class AdminController extends Controller
{
    //验证码配置
    public function actions()
    {
        return [
            'captcha' => [
                'class' => yii\captcha\CaptchaAction::className(),
                'width' => 80,
                'minLength' => 3,
                'maxLength' => 3,
            ],
        ];
    }
    //过滤器配置
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),//依赖模型
                'except'=>['login','logout','captcha','upload','s-upload'],
            ],
        ];
    }
    //管理员列表展示
    public function actionIndex()
    {

        //查处的数据库所有数据返回给视图
        $admins = Admin::find()->where(['status' => 1]);
        $page = new yii\data\Pagination([
            'totalCount'=>$admins->count(),
            'defaultPageSize'=>2
        ]);
        $admin = $admins->offset($page->offset)->limit($page->pageSize)->all();
        //返回给试图
        return $this->render('index', ['admins' => $admin,'pager'=>$page]);
    }
    //为用户添加角色
    public function actionAdd()
    {
        //实例化模型
        $model = new Admin();
        //判定是否为post接受数据
        if (yii::$app->request->isPost) {
            //执行接收到的信息（绑定表单）
            $model->load(yii::$app->request->post());
            //验证数据
            if ($model->validate()) {
                //添加字符串未密钥赋值方便后面自动登录
                $model->auth_key = 'frfhuds';
                //保存数据
                $model->save();
                //为用户添加角色
                $model->getAddrole();
                //提示信息
                yii::$app->session->setFlash('success', '添加成功');
                //跳转页面
                return $this->redirect(['index']);
            } else {
                //var_dump($model->getErrors());exit;
                return $this->render('add', ['model' => $model]);
            }
        }
        //将模型对象返回视图
        return $this->render('add', ['model' => $model]);
    }
    //编辑
    public function actionEdit($id)
    {
        //通过id获取登陆用户一条数据库信息
        $editModel = Admin::findOne(['id' => $id]);
        //根据接收数据方式判定处理数据还是显示页面
        if (yii::$app->request->isPost) {
            //通过mixing对象执行接受数据$$验证数据
            if ($editModel->load(yii::$app->request->post())&&$editModel->validate()) {
                //保存数据
                $editModel->save();
                //实例化组件
                $authManager = yii::$app->authManager;
                //通过id获取相对应角色
                $authManager->revokeAll($editModel->id);
                //调用模型处理数据(关联遍历分配角色)
                $editModel->getAddrole();
                //提示信息
                yii::$app->session->setFlash('success', '更新成功');
                //跳转页面
                $this->redirect(['admin/index']);
            }else{
                var_dump($editModel->getErrors());exit;
            }
        }
        $editModel->getRole($id);
        //将模型返回给试图
        return $this->render('add', ['model' => $editModel]);
    }
    //删除
    public function actionDel($id)
    {
        //通过id删除一条数据
        $delModel = Admin::findOne(['id' => $id]);
        //改变信息状态
        $delModel->status = -1;
        //保存数据
        $delModel->save();
        //提示信息
        yii::$app->session->setFlash('default', '删除成功');
        //跳转页面
        $this->redirect(['index']);
    }
    //登陆
    public function actionLogin()
    {
        //实例化表单模型
        $model = new Login();
        //接受数据
        if ($model->load(yii::$app->request->post())) {
            //验证
            if ($model->validate()) {
                //
                $admin = Admin::findOne(['username' => $model->username]);
                //绑定已存在用户名获取admin对象
                if ($admin) {
                    //进行明文密码和Hash比对
                    if (yii::$app->security->validatePassword($model->password, $admin->password_hash)) {
                        //调用user内置对象登陆方法登陆
                        yii::$app->user->login($admin,7*24*3600);
                            //提示信息
                            yii::$app->session->setFlash('default','登陆成功');
                            //跳转页面
                            return $this->redirect(['index']);
                    }else{
                        $model->addError('password','密码错误');
                    }
                    } else {
                        $model->addError('username', '用户名不存在');
                    }
                 }
             }
            //返回给视图
            return $this->render('login', ['model' => $model]);
    }
        public function actionLogout(){
        yii::$app->user->logout();
            //提示信息
            yii::$app->session->setFlash('default','退出成功');
            //跳转页面
            return $this->redirect(['login']);
        }


        /*1修改密码*/
        public function actionChangePassword(){
            //2实例化表单模型对象
            $changepass = new Changepass();
                //3：接受数据
            if($changepass->load(yii::$app->request->post())){
                //5：验证：验证用户输入信息合法性
                if($changepass->validate()){
                    //5验证用户输入信息合法性
                    $admin= yii::$app->user->identity;
                    //新密码和数据库密码输入是否一致，
                    if(yii::$app->security->validatePassword($changepass->password,$admin['password_hash'])){
                        //将新密码重新赋值给原密码
                        $admin->password = $changepass->newpassword;
                        //保存
                         $admin->save();
                         //var_dump($admin);exit;
                         yii::$app->session->setFlash('succcess','修改密码成功');
                         //跳转页面
                         return $this->redirect(['index']);
                    }else{
                         $changepass->addError('password','密码输入有误，请重新输入!');
                    }
                }else{
                    var_dump($changepass->getErrors());exit;
                }
            }
//1:显示修改列表
            return $this->render('changPass',['model'=>$changepass]);
        }
        public function actionTest(){
            $model=new Admin();
            $res=$model->getMenuItems();
            var_dump($res);
        }
    }
