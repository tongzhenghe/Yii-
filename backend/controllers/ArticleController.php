<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/10
 * Time: 23:11
 */

namespace backend\controllers;


use backend\models\Article;
use backend\models\Article_category;
use backend\models\Article_detail;
use yii\web\Controller;
use yii;
use flyok666\uploadifive\UploadAction;
use flyok666\qiniu\Qiniu;
class ArticleController extends Controller
{
    //显示列表页面
    public function actionArticlelist(){
        $data = Article::find()->where(['status'=>1]);
        //分页
        $page = new yii\data\Pagination([
            'totalCount'=>$data->count(),
            'pageSize'=>4
        ]);
        $row = $data->offset($page->offset)->limit($page->pageSize)->all();
        //将数据分配到视图
       return $this->render('articlelist',['shuju'=>$row,'pager'=>$page]);
    }
    public function actionContent($id){
        //显示内容
        $content = Article_detail::findOne($id);
        //返回给试图
        return $this->render('content',['content'=>$content]);
    }
    //显示分类名称
    public function actionCatigory_name(){
        //获取数据
      $data = Article_category::find()
          ->select('name')
          -> from('article_category')
          ->all();
        //返回给首页列表试图
        return $this->render('articlelist',['data'=>$data]);
    }
    //添加功能
    public function actionAdd(){
        $articleModel = new Article();
$article_detailModel = new Article_detail();
//if(yii::$app->request->isPost){
//    if($articleModel->load(yii::$app->request->post())&&$article_detailModel->load(yii::$app->request->post())&&$articleModel->validate()&&$article_detailModel->validate()){
//        //保存数据
//        if($articleModel->save()&&$article_detailModel->save()){
//            $article_detailModel->article_id = $articleModel->id;
//            //提示信息
//            yii::$app->session->setFlash('succcess','添加成功');
//            //跳转页面
//            $this->redirect(['article/articlelist']);
//        }
//    }
//}
//通过判定数据请求方式判定处理数据还是显示添加列表
if(yii::$app->request->isPost){
    //接受所有数据
    if($articleModel->load(yii::$app->request->post())&&$article_detailModel->load(yii::$app->request->post())){
        if($articleModel->validate()&&$article_detailModel->validate()){
            //保存数据
            $articleModel->save();
            $article_detailModel->article_id = $articleModel->id;
            $article_detailModel->save();
            //提示信息
            yii::$app->session->setFlash('succcess','添加成功');
            //跳转页面
            $this->redirect(['article/articlelist']);
          }else{
          }
        }else{
        var_dump($articleModel->getErrors());
    }
      }
        $article_category = Article_category::find()->all();
        //把模型返回给视图显示添加列表
        return $this->render('add',['model'=>$articleModel,'article_detailModel'=>$article_detailModel,'article_category'=>$article_category]);
  }
        //添加内容
        public function actionAddcontent(){
                //实例化内容模型
                $Article_detailModel = new Article_detail();
                //通过模型调用load方法执行语句
                if(yii::$app->request->isPost){
                    $Article_detailModel->load(yii::$app->request->post());
                    //验证数据
                    if($Article_detailModel->validate()){
                        //保存数据到数据库
                        $Article_detailModel->save();
                    }
        }
         //将模型返回给视图
        return $this->render('add',['model'=>$Article_detailModel]);
        }
//将文章分类名称查出来返回到文章添加下拉列表

//        public function actionCatigory()
//        {
//            //查询出数据
//            $data = Article_category::find()
//                ->select('name')
//                ->from('article_category')
//                ->all();
////            var_dump($data);die;
//            //返回给视图
//            return $this->render('add',['data'=>$data]);
//        }
    //编辑功能
    public function actionEdit($id){
        $article_detailModel = new Article_detail();
        $articleModel = Article::findOne(['id'=>$id]);
        if(yii::$app->request->isPost){
            //实现编辑功能
            $articleModel->load(yii::$app->request->post());//返回布尔型
            //实例化上传文件
//            $articleModel->imgFile = yii\web\UploadedFile::getInstance($articleModel,'imgFile');
            //验证数据
         if($articleModel->validate()){//判断如果验证通过就执行以下操作
//========================通过插件实现======================================
//if($articleModel->imgFile){//判定如果上传图片，就执行以下操作
////验证上传文件设置新的文件路径
//$pathFile = '/upload/'.uniqid().'.'.$articleModel->imgFile->extension;
////找到玩象征路径在保存到数据库
//$articleModel->imgFile->saveAs(yii::getAlias('@webroot').$pathFile,false);
////把文件赋值给photo
//$articleModel->photo = $pathFile;
//==========================================================================
         }
            //保存数据
            $articleModel->save();
            #$article_detailModel->article_id = $articleModel->id;
            $article_detailModel->save();
            //跳转到当前面
            yii::$app->session->setFlash('success','成功编辑'.yii::$app->request->get('id').'条数据');
            return $this->redirect(['article/articlelist']);
          }
        //把模型返回给视图显示添加列表
        $article_category = Article_category::find()->all();
        return $this->render('add',['model'=>$articleModel,'article_detailModel'=>$article_detailModel,'article_category'=>$article_category]);
         }
    //删除
    public function actionDel($id){
        $articleModel = Article::findOne($id);//通过id改变一条数据的状态
        $articleModel->status = -1;//改变状态
        if($articleModel->save()){
            //跳转到当前面
            yii::$app->session->setFlash('success','删除第'.yii::$app->request->get('id').'条数据');
            return $this->redirect(['article/articlelist']);
        }else{
            var_dump($articleModel->getErrors());exit;
        }
    }

    //插件
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
                    //$action->output['fileUrl'] = $action->getWebUrl();
//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                    //上传图片到其牛云
                    $config = [
                        'accessKey'=>'GyRNA6SodIxZNHPw96aZFSObOmpG40voayV_id3l',
                        'secretKey'=>'uylLO4dTgS76_dc_s6D-oPxquLNbMDxy-bSB4mZJ',
                        'domain'=>'http://ouk9h3ujg.bkt.clouddn.com',//测试域名
                        'bucket'=>'yiishop',//存储空间名称
                        'area'=>Qiniu::AREA_HUADONG//区域
                    ];
                        $qiniu = new Qiniu($config);
                        $file = $action->getWebUrl();
                        $qiniu->uploadFile($action->getSavePath(),$action->getWebUrl());//上传文件到七牛云存储
                        $url = $qiniu->getLink($file);//根据文件名获取七
                        $action->output['fileUrl'] = $action->getWebUrl();//输出图片地址
                },
            ],

        ];
    }
//测试七牛上传文件
//public function actionQiniu(){
//    $config = [
//        'accessKey'=>'GyRNA6SodIxZNHPw96aZFSObOmpG40voayV_id3l',
//        'secretKey'=>'uylLO4dTgS76_dc_s6D-oPxquLNbMDxy-bSB4mZJ',
//        'domain'=>'http://ouk9h3ujg.bkt.clouddn.com',//测试域名
//        'bucket'=>'yiishop',//存储空间名称
//        'area'=>Qiniu::AREA_HUADONG//区域
//    ];
//    $qiniu = new Qiniu($config);
//    $key = 'tzhe';
//    //"E:/Tyii/tyii/backend/web/upload/598db9b0c73d8.jpg"
//    $file = yii::getAlias('@webroot').'/upload/04/7c/047cfcdd01ed01a5461d99a5af2f989413f6407d.png';
//    $qiniu->uploadFile($file,$key);//上传文件到七牛云存储
//    $url = $qiniu->getLink($key);//根据文件名获取七牛云的文件路径
//    //var_dump($url);
//
//}

}