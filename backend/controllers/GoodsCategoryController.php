<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/13
 * Time: 16:54
 */

namespace backend\controllers;
use backend\models\Goods_category;
use yii;
use yii\web\Controller;

class GoodsCategoryController extends Controller
{
    //url:goods-category/index
    public function actionIndex(){
       $datas = Goods_category::find();
       //分页
        $page = new yii\data\Pagination([
            'totalCount'=>$datas->count(),
            'defaultPageSize'=>6
        ]);
        //得到limit和offset值
        $rows = $datas->offset($page->offset)->limit($page->pageSize)->all();
        //返回视图
        return $this->render('index',['datas'=>$rows,'pager'=>$page]);
    }
    //goods/add
    public function actionAdd(){
        //实例化模型对象
        $addModel = new Goods_category();
        //通过数据接收方式判定显示页面还是处理数据
        if(yii::$app->request->isPost){
            //模型处理数据并且验证数据
            $addModel->load(yii::$app->request->post());
                if($addModel->validate()){
                    //判定添加子分类还是父分类
                    if($addModel->parent_id){
                        //创建子分类
                        $parent = Goods_category::findOne(['id'=>$addModel->parent_id]);
                        //创建子饭呢类
                        $addModel->prependTo($parent);

                    }else{
                        //佛则创建顶级id
                        $addModel->makeRoot();
                    }
                //保存数据
                $addModel->save();
                //提示信息
                yii::$app->session->setFlash('success','添加成功');
                //跳转页面
                return $this->redirect(['goods-category/index']);
            }
        }
        return $this->render('add',['model'=>$addModel]);
    }
//==============//插件创建节点========
    public function actionCreatenode(){
        $parent = Goods_category::findOne(['id'=>1]);
        //实例化模型对象
        $child = new Goods_category();
        //创建子分类
        $child->name = '大家电';
        $child->intro = '大的家电';
        $child->parent_id = 1;
        $child->prependTo($parent);
//====================================
    }
    //ztre
    public function actionTreez(){
        //$this->layout = false;//不加载布局文件  $this->>renderPartial()
        $models = Goods_category::find()->select(['id','name','parent_id'])->asArray()->all();
        return $this->renderPartial('treez',['models'=>$models]);
    }
//====================================
    //编辑：goods/edit
    public function actionEdit($id){
//=======================================
//        $editModel = new Goods_category();
//        //通过数据接收方式判定显示页面还是处理数据
//        if(yii::$app->request->isPost){
//            //模型处理数据并且验证数据
//            $editModel->load(yii::$app->request->post());
//            if($editModel->validate()){
//                //判定添加子分类还是父分类
//                if($editModel->parent_id){
//                    //创建子分类
//                    $parent = Goods_category::findOne(['id'=>$editModel->parent_id]);
//                    //创建子饭呢类
//                    $editModel->prependTo($parent);
//
//                }else{
//                    //佛则创建顶级id
//                    $editModel->makeRoot();
//                }
//                //保存数据
//                $editModel->save();
//                //提示信息
//                yii::$app->session->setFlash('success','编辑成功');
//                //跳转页面
//                return $this->redirect(['goods-category/index']);
//            }
//        }
//=================================================================
        $modelObj = Goods_category::findOne($id);
      if($modelObj->load(yii::$app->request->post())){
          //验证数据
          if($modelObj->validate()){
              //保存数据
              $modelObj->save();
              //提示信息
              yii::$app->session->setFlash('success','编辑成功');
              //跳转页面
              return $this->redirect(['index']);
          }
      }
        return $this->render('add',['model'=>$modelObj]);
    }

    //删除url:goods/del
    public function actionDel($id){
        //实例化模型对象
        //$delModel = new Goods_category();
        //根据id删除数据
        Goods_category::deleteAll(['id'=>$id]);
        //提示信息
        yii::$app->session->setFlash('success','删除成功');
        //跳转页面
        $this->redirect(['index']);
    }
}