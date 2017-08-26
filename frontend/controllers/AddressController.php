<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/21
 * Time: 17:44
 */

namespace frontend\controllers;


use frontend\models\Address;
use yii\web\Controller;
use yii;
class AddressController extends Controller
{
    public $enableCsrfValidation = false;//接受表单省去前缀
    public function actionIndex()
    {
        //实例化model
        $model = new Address();
        if ($model->load(yii::$app->request->post(), '')) {
            //验证数据
            if ($model->validate()) {
                //保存数据
                if ($model->save()) {
                    //跳转页面
                    return $this->redirect(['address/index']);
                }
            } else {
                var_dump($model->getErrors());
                exit;
            }
        }
            //得到所有数据显示列表
            //在视图遍历出得到的数据
            $dataObj = Address::find()->all();
            //处理数据
            return $this->render('header', ['shuju' => $dataObj]);
    }

    //修改地址
    public function actionEdit($id){
        //获取一条数据
        $dataObj = Address::findOne($id);
        //执行和接受数据
        if($dataObj->load(yii::$app->request->post(),'')){
            //验证数据
            if($dataObj->validate()){
                $dataObj->save();
                //跳转页面
                return $this->redirect(['address/index']);
            }
        }
         $rowsObj = Address::find()->all();//列表
        return $this->render('header',['shuju'=>$rowsObj,'data'=>$dataObj]);
    }

    //删除地址
    public function actionDel($id){
        $delObj = Address::findOne(['id'=>$id]);
        //删除
        if(yii::$app->db->createCommand()->delete('address',['id'=>$id])->execute()){
            echo "删除成功";
            //保存
            $delObj->save();
            //调准页面
            return $this->redirect(['index']);
        }else{
            var_dump($delObj->getErrors());exit;
        }
    }
}