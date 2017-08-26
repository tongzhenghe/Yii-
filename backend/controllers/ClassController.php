<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/11
 * Time: 13:34
 */

namespace backend\controllers;


use backend\models\Classs;
use yii\web\Controller;
use yii;
class ClassController extends Controller
{
    //url:class/index
    public function actionIndex(){
      //分页
       //查询所有数据
        $rows = Classs::find();
       //实例化当前页
        $page = new yii\data\Pagination([
            'totalCount'=>$rows->count(),//数据总条数
            'defaultPageSize'=>2,
            'pageSizeLimit' => [1, 20]
        ]);
        $classs = $rows->offset($page->offset)->limit($page->pageSize)->all();

        //将数据返回给视图
        return $this->render('classlist',['shuju'=>$classs,'pager'=>$page]);
    }
    //url：class/add添加功能
    public function actionAdd(){
        //实例化模型对象
        $addModel = new Classs();
        //根据数据传输方式判定显示页面还是处理数据
        if(yii::$app->request->isPost){

        //接受所有数据并执行语句
          $addModel->load(yii::$app->request->post());
            //$addModel->class_name = '';
            //验证数据
            if($addModel->validate()){
            //就保存到数据库
              $addModel->save();
            //提示
              yii::$app->session->setFlash('success','添加成功');
            //跳转页面
             return $this->redirect(['class/index']);
            }
            //var_dump($addModel->getErrors());die;
        }
        //显示添加表单将模型返回给添加试图
        return $this->render('add',['model'=>$addModel]);
    }

//编辑
    public function actionEdit($class_id){
        $editModel = Classs::findOne(['class_id'=>$class_id]);
       //通过数据接受方式判断显示页面还是处理数据
        if(yii::$app->request->isPost){
            //编辑功能
            $editModel->load(yii::$app->request->post());
            if($editModel->validate()){
                //保存数据
                $editModel->save();
                //提示
                yii::$app->session->setFlash('success','编辑成功');
                return $this->redirect(['class/index']);
                 }
            }
        return $this->render('add',['model'=>$editModel]);
    }
    //删除
    public function actionDel($class_id){
        //实例化模型对象
       Classs::deleteAll(['class_id'=>$class_id]);
        //保存数据到数据库
        yii::$app->session->setFlash('success','删除成功');
        //跳转页面
        return $this->redirect(['class/index']);
        //var_dump($delModel);
    }
}















