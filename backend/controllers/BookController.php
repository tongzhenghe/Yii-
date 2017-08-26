<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/11
 * Time: 20:38
 */

namespace backend\controllers;


use backend\models\Books;
use backend\models\Student;
use yii\web\Controller;
use yii;
class BookController extends Controller
{
    //显示首页:url"book/index
    public function actionIndex(){
          //查出图书数据
        $data = Books::find()->asArray()
            ->select('*')
            ->from('books')
            ->innerJoin('student')
            ->where('books.student_id=student.student_id')
            ->all();
            //将数据返回给视图
           return $this->render('bookslist',['shuju'=>$data]);
    }
    //添加页面
    public function actionAdd(){
        $addModel = new Books();
        if(yii::$app->request->isGet){//通过数据接收方式判定是处理数据还是显示页面
            //查询所有数据
            $data = Student::find()
                ->select("*")
                ->from("books")
                ->innerJoin('student','student.student_id=books.id')
                ->all();
                //var_dump($data);die;
                //显示页面：将模型返回给视图
           return $this->render('add',['model'=>$addModel,'shuju'=>$data]);
        }else{
            //接受数据
           $addModel->load(yii::$app->request->post());
            //接受上传文件实例化文件
           $addModel->imgFile = yii\web\UploadedFile::getInstance($addModel,'imgFile');
            //验证数据
            if($addModel->validate()){
                if($addModel->imgFile){
                    //设置新路径
                    $path = '/upload/'.uniqid().'.'.$addModel->imgFile->extension;
                    //保存数据到数据库
                    if($addModel->imgFile->saveAs(yii::getAlias('@webroot').$path,false)){
                       $addModel->logo = $path;
                    }
                }
                //保存数据
                $addModel->save();
                //提示信息
                yii::$app->session->setFlash('success','添加成功');
                //跳转页面
                return $this->redirect(['book/index']);
            }
        }
        var_dump($addModel->getErrors());
    }
    //编辑功能
    public function actionEdit($id){
        $editModel = Books::findOne($id);
        if(yii::$app->request->isGet){//判定接受数据方式显示页面还是处理数据
            //显示列表
        return $this->render('edit',['model'=>$editModel]);
        }else{
            //接受数据
            $editModel->load(yii::$app->request->post());
            //接受文件实例化
            $editModel->imgFile = yii\web\UploadedFile::getInstance($editModel,'imgFile');
            //验证
            if($editModel->validate()){
                if($editModel->imgFile){
                    //设置新路径
                    $newPath = '/upload/'.uniqid().'.'.$editModel->imgFile->extension;
                    //保存到数据库
                    if($editModel->imgFile->saveAs(yii::getAlias('@webroot').$newPath,false)){
                        $editModel->logo = $newPath;
                    }
                }
            }
            //保存数据
            $editModel->save();
            //提示信息
            yii::$app->session->setFlash('success','编辑成功');
            //跳转页面
            return $this->redirect(['book/index']);
        }
    }
    public function actionDel($id){
     yii::$app->db->createCommand()->delete('books','id='.$id)->query();
        //提示信息
        yii::$app->session->setFlash('success','删除成功');
        //跳转
        return $this->redirect(['book/index']);
    }
}















