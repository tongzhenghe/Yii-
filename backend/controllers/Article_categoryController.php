<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/12
 * Time: 22:52
 */

namespace backend\controllers;


use backend\models\Article_category;
use yii\web\Controller;
use yii;
class Article_categoryController extends Controller

{
    //article_category/index
    public function actionIndex(){
        //显示列表
        $data = Article_category::find()->where(['status'=>1])->all();
        //返回到页面
        return $this->render('article_categoryList',['data'=>$data]);
    }
    //添加article_category\add
    public function actionAdd()
    {
        $addModel = new Article_category();
        //根据数据接受方式判定显示页面还市处理数据
        if(yii::$app->request->isPost){
            //接受数据
            $addModel->load(yii::$app->request->post());
            //验证数据
            if($addModel->validate()){
            //保存数据
              $addModel->save();
            //提示信息
               yii::$app->session->setFlash('success','添加成功');
            //跳转页面
             return $this->redirect(['article_category/index']);
            }
        }
            //返回模型给视图显示页面
            return $this->render('add',['model'=>$addModel]);
    }
    //编辑article_category/edit
    public function actionEdit($id)
    {
        //通过模型调用方法处理数据
        $editModel= Article_category::findOne($id);
        //根据数据接受方式判定显示页面还市处理数据
        if($editModel->load(yii::$app->request->post())){
            //验证数据
            if($editModel->validate()){
             //保存数据
             $editModel->save();
             //提示信息
             yii::$app->session->setFlash('success','编辑成功');
             //跳转页面
            return $this->redirect(['article_category/index']);
            }
        }
        //返回模型给视图显示页面
        return $this->render('add',['model'=>$editModel]);
    }
    //删除rticle_category/edit
    public function actionDel($id){
        //实例化魔心对象
        $delModel = Article_category::findOne($id);
        //将状态值设置为-1
        $delModel->status = -1;
        //保存数据到数据库
        $delModel->save();
        //提示信息
        yii::$app->session->setFlash('success','删除成功');
        //跳转页面
        return $this->redirect(['article_category/index']);
    }
}