<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/10
 * Time: 16:38
 */

namespace backend\controllers;


use backend\models\Books;
use backend\models\Brand;
use yii\web\Controller;
use yii;
use flyok666\uploadifive\UploadAction;
use flyok666\qiniu\Qiniu;
class BrandController extends Controller
{
    //显示管理列表brand/index
    public function actionIndex(){
        //分页
        //从数据库中读取数据
        $rows = Brand::find()->where(['status'=>1]);
        //计算得出
        $page = new yii\data\Pagination([
            //总条数
            'totalCount'=>$rows->count(),
            'pagesize'=>6,
        ]);
        $brands = $rows->offset($page->offset)->limit($page->pageSize)->all();
        //将数据返回给视图
        return $this->render('brandlist',['shuju'=>$brands,'pager'=>$page]);
    }
//===============================================
    //完成添加
    public function actionAdd(){
        //实例化模型对象
        $brandmodel = new Brand();
        //var_dump($brandmodel);die;
       //根据数据传输方式判定显示页面还是处理数据
        if(yii::$app->request->isPost){
            //模型调用load方法接受所有数据
            $brandmodel->load(yii::$app->request->post());
            //实例化上传文件类
//            $brandmodel->image = yii\web\UploadedFile::getInstance($brandmodel,'image');
            //数据验证 //验证成功就保存数据
            if($brandmodel->validate()){
//                if ($brandmodel->image){
//                    //设置文件路径
//                    $filepath = '/upload/'.uniqid().'.'.$brandmodel->image->extension;
//                    $brandmodel->image->saveAs(yii::getAlias('@webroot').$filepath,false);
//                    $brandmodel->logo = $filepath;//保存到数据库
//                }
                //保存数据到数据库
                $brandmodel->save();
                //设置提示信息
                yii::$app->session->setFlash('success','添加成功');
                //跳转页面
                return  $this->redirect(['brand/index']);
           }
        }
        $data = Brand::find()->select('logo')->from('brand')->asArray()->all();
        //显示添加列表:将模型对象返回给视图
        return $this->render('brandadd',['model'=>$brandmodel,'logo'=>$data]);
    }
    //编辑功能
    public function actionEdit($id){
        $brandMdel = Brand::findOne(['id'=>$id]);
        //实例化模型显示编辑页面
        //通过传送数据方式判定是显示页面还是就处理数据
        if(yii::$app->request->isPost){
            //编辑页面
            $brandMdel->load(yii::$app->request->post());
            //接受上传的文件
//            $brandMdel->image = yii\web\UploadedFile::getInstance($brandMdel,'image');

            //验证数据
            if($brandMdel->validate()){
                //设置新的文件
//                $pathfile = '/upload/'.uniqid().'.'.$brandMdel->image->extension;
                //在保存文件
//                if($brandMdel->image->saveAs(yii::getAlias('@webroot').$pathfile,false)){
//                    $brandMdel->logo = $pathfile;//保存到数据库
//                }
                //保存数据
                $brandMdel->save();
                //显示提示信息
                yii::$app->session->setFlash('success','编辑成功');
                //跳转页面
                return $this->redirect(yii\helpers\Url::to(['brand/index']));
                }
            }
        //将数据返回给视图
        return $this->render('brandadd',['model'=>$brandMdel]);
    }
    //删除
    public function actionDel($id){
        $brandModel = Brand::findOne($id);
        $brandModel->status = -1;
        $brandModel->save();
        //提示信息
        yii::$app->session->setFlash('success','删除成功');
        //调转页面
        $this->redirect(\yii\helpers\Url::to(['brand/index']));
    }

//=========================================
//上传插件
    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
//                'format' => function (UploadAction $action) {
//                    $fileext = $action->uploadfile->getExtension();
//                    $filename = sha1_file($action->uploadfile->tempName);
//                    return "{$filename}.{$fileext}";
//                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();
//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
//                    $config = [
//                        'accessKey'=>'GyRNA6SodIxZNHPw96aZFSObOmpG40voayV_id3l',
//                        'secretKey'=>'uylLO4dTgS76_dc_s6D-oPxquLNbMDxy-bSB4mZJ',
//                        'domain'=>'http://ouk9h3ujg.bkt.clouddn.com',//测试域名
//                        'bucket'=>'yiishop',//存储空间名称
//                        'area'=>Qiniu::AREA_HUADONG//区域
//                    ];
//                    $qiniu = new Qiniu($config);
//                    $key = 'tzhe';
//                    $file = yii::getAlias('@webroot').'/upload/598db9b0c73d8.jpg';
//                    $qiniu->uploadFile($file,$key);//上传文件到七牛云存储
//                    $url = $qiniu->getLink($key);//根据文件名获取七牛云的文件路径
//                    $action->output['fileUrl'] = $url;
                },
            ],
        ];
    }
    //测试七牛上传文件
//    public function actionQiniu(){
//        $config = [
//            'accessKey'=>'GyRNA6SodIxZNHPw96aZFSObOmpG40voayV_id3l',
//            'secretKey'=>'uylLO4dTgS76_dc_s6D-oPxquLNbMDxy-bSB4mZJ',
//            'domain'=>'http://ouk9h3ujg.bkt.clouddn.com/',//测试域名
//            'bucket'=>'yiishop',//存储空间名称
//            'area'=>Qiniu::AREA_HUADONG//区域
//        ];
//        $qiniu = new Qiniu($config);
//        $file = yii::getAlias('@webroot').'/upload/image/20170817/150298335573303222.png';
//        var_dump($file);
//        $qiniu->uploadFile($file);//上传文件到七牛云存储
//        $url = $qiniu->getLink($file);//根据文件名获取七牛云的文件路径

//    }
}