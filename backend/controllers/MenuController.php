<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/20
 * Time: 11:22
 */

namespace backend\controllers;


use yii\web\Controller;
use \backend\models\Menu;
use yii;
class MenuController extends Controller
{
//    menu/index
    public function actionIndex(){
        $menus = Menu::find();
        $page = new yii\data\Pagination([
            'totalCount' => $menus->count(),
            'defaultPageSize'=>5
        ]);
        $menu = $menus->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['menus'=>$menu,'page'=>$page]);
    }
    //添加菜单
    public function actionAdd(){
        $addModel = new Menu();

        if($addModel->load(yii::$app->request->post())&&$addModel->validate()){
             //保存数据
            $addModel->save();
            //提示信息
            yii::$app->session->setFlash('success','添加成功');
            //跳转页面
            return $this->redirect(['index']);
        }
        return $this->render('add',['model'=>$addModel]);
    }
    //编辑菜单
    public function actionEdit($id){
        //获取数据
        $model = Menu::findOne(['id'=>$id]);
        //处理数据/验证
        if($model->load(yii::$app->request->post())&&$model->validate()){
            //保存数据
            if($model->save()){
                //提示信息
                yii::$app->session->setFlash('success','编辑成功');
                //跳转页面
                return $this->redirect(['index']);
            }
        }
        //显示
        return $this->render('add',['model'=>$model]);
    }
    //删除菜单
    public function actionDel($id){
        //获取一条数据
        Yii::$app->db->createCommand()->delete('menu',['id'=>$id])->execute();
        //提示信息
        yii::$app->session->setFlash('success','删除成功');
        //跳转页面
        return $this->redirect(['index']);
    }
}