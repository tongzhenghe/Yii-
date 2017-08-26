<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/11
 * Time: 16:16
 */

namespace backend\controllers;


use backend\models\Classs;
use backend\models\Student;
use yii\web\Controller;
use yii;
class StudentController extends Controller
{
    //显示学生列表
    public function actionIndex(){
            //获取所有数据
            $data = yii::$app->db->createCommand("select * from classs  INNER JOIN student ON student.class_id=classs.class_id")->queryAll();
            $rows = Student::find();
            //分页
            $page = new yii\data\Pagination([
                'totalCount'=>$rows->count(),//数据总条数
                'defaultPageSize'=>1//每页显示条数
        ]);
        $students = $rows->offset($page->offset)->limit($page->pageSize)->all();
        //返回给试图
        return $this->render('studentlist',['shuju'=>$data,'pager'=>$students]);
    }
    public function actionAdd(){
            $addModel = new Student();

    }
    //编辑
    public function actionEdit($student_id){
        $editModel = Student::findOne(['student_id'=>$student_id]);
        $QueryObj = new yii\db\Query();
        if(yii::$app->request->isGet){
            //显示编辑页面
           $data = $QueryObj
            ->select('*')
            ->from('student')
            ->where('student.class_id'==='calsss.class_id')
            ->innerJoin('classs')
            ->all();
           //显示列表
            return $this->render('edit',['shuju'=>$data,'model'=>$editModel]);
        }else{
            //接受数据
            $editModel->load(yii::$app->request->post());
            //保存数据
            $editModel->save();
            //提示
            yii::$app->session->setFlash('success','编辑成功');
            //跳转页面
            return $this->redirect(['student/index']);
        }
    }
    //删除
    public function actionDel($student_id){
        yii::$app->db->createCommand()->delete('student','student_id='.$student_id)->execute();
        //提示
        yii::$app->session->setFlash('success','删除成功');
        //跳转页面
        return $this->redirect(['student/index']);
    }


}















