<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/14
 * Time: 14:37
 */

namespace backend\controllers;
use backend\models\Brand;
use backend\models\Goods;
use backend\models\Goods_category;
use backend\models\Goods_day_count;
use backend\models\Goods_gallery;
use backend\models\Goods_intro;
use yii\web\Controller;
use flyok666\uploadifive\UploadAction;
use flyok666\qiniu\Qiniu;
use yii;
class GoodsController extends Controller
{
    //显示商品列表:
    public function actionIndex()
    {
//        $model = new G
//        $query = Goods::find();
//        //接收表单提交的查询参数
//        $model->search($query);
        //商品名称含有"耳机"的  name like "%耳机%"
        //$query = Goods::find()->where(['like','name','耳机']);
        //获取get方式接受的数据
//        $modelGet = $_GET['name'];
        //搜索语句
        $datas = Goods::find();
        //分页goods/index
        $page = new yii\data\Pagination([
            'totalCount' => $datas->count(),
            'defaultPageSize' => 4
        ]);
        //计算offset和limit
        $pagemodel = $datas->offset($page->offset)->limit($page->pageSize)->all();
        return $this->render('goodsList', ['datas' => $pagemodel, 'pager' => $page]);
    }
//===================添加Goods==========================
    public function actionAdd(){
        $goodsGalleryModel = new Goods_gallery();
        //实例化商品简介表
        $intro = new Goods_intro();
        //实例化Goods模型
        $addModel = new Goods();
        //实例化商品统计个数对象
        $countModel = new Goods_day_count();
        //判定如果post接受方式处理数据
        if(yii::$app->request->isPost){
             //调用模型执行接受数据和验证数据
            $addModel->load(yii::$app->request->post());
            $intro->load(yii::$app->request->post());
//            $countModel->day = $time;
            //计算货号
//            $sn = $time.str_pad($count+1,4,0,STR_PAD_LEFT);
//            $addModel->sn = $sn;
//            $addModel->create_time = $time;
            //验证数据
            if($addModel->validate()&&$intro->validate()){
                $time = date('Y-m-d');
                //计算个数
                $count_day = Goods_day_count::findOne(['day'=>$time]);
                if($count_day){
                    $count_day->day = date('Y-m-d H:m:s',time());
                    $addModel->create_time = date('Y-m-d H:m:s',time());
                    $count = ++$count_day->count;
                    $addModel->sn = $time.str_pad($count,4,0,STR_PAD_LEFT);
                    //var_dump($addModel->sn);exit;
                   // $addModel->sn = $time.sprintf('%04d',$count);
                    $addModel->create_time = date(time());
                    //保存数据
                    $addModel->save();
                    $count_day->save();
                }/*else{
                    if ($count_day == null) {
                        $day_count = new Goods_day_count();
                        $day_count->day = $time;
                        $day_count->count = 0;
                        //没有记录 今天没有添加过商品
                        //$model->sn = 20160530 +  0001
                    }
                    $count_day = Goods_day_count::findOne(['day'=>$time]);
                    $count = ++$count_day->count;
                    $addModel->sn = $time.str_pad($count,4,0,STR_PAD_LEFT);
                    // $addModel->sn = $time.sprintf('%04d',$count);
                    //保存数据
                    $addModel->save();
//                    $count_day->save();
                }*/
                $goodsGalleryModel->goods_id = $addModel->id;
                $addModel->save();
                $countModel->day = $addModel->create_time;
                $countModel->save();
                //主表id赋值给简介表id
                $intro->goods_id = $addModel->id;
                //保存简介
                $intro->save();
                //提示信息
                yii::$app->session->setFlash('success','添加成功');
                //跳转页面
                return $this->redirect(['goods/index']);
            }
            var_dump($addModel->getErrors());
        }
        //将模型返回给视图
        return $this->render('add',['model'=>$addModel,'intromodel'=>$intro]);
        }
//===================编辑=======================
    public function actionEdit($id){
        $goods_categoryModel = new Goods_category();
        //实例化商品分类模型对象
        $editModel = Goods::findOne(['id'=>$id]);
        $intro = Goods_intro::findOne(['goods_id'=>$id]);
        //判定如果post接受方式处理数据
        if(yii::$app->request->isPost){
            //执行数据
            $editModel->load(yii::$app->request->post());
            $intro->load(yii::$app->request->post());
            //验证数据
            if($editModel->validate()&&$intro->validate()){
                //保存数据
                $editModel->save();
                $goods_categoryModel->save();
                $intro->save();
                //提示信息
                yii::$app->session->setFlash('success','编辑成功');
                //跳转页面
                return $this->redirect(['goods/index']);
            }
        }
        //返回视图
        return $this->render('add',['model'=>$editModel,'intromodel'=>$intro]);
    }
//====================删除==================
    //删除
    public function actionDel($id){
        Yii::$app->db->createCommand()->delete('goods',['id'=>$id])->execute();
        //改变数据状态
        //$delModel->status = -1;
        //保存数据
        //提示信息
        yii::$app->session->setFlash('success','删除成功');
        //跳转页面
        return $this->redirect(['goods/index']);
    }
    //计算商品个数
    public function actionGoodsCount(){
        $countModel = new Goods_day_count();
        //在通过以上时间写sql语句查询商品条数
        $countArr = Goods::find()->asArray()
            ->select('count(*)')
            ->from('goods')
            ->groupBy('create_time')
            ->all();
        //将数据条数赋值给另外统计条数表
        $countModel->count = $countArr[0]['count(*)'];
        //保存到数据库
        $countModel->save();
    }

//保存图片路径
public function actionLogo(){
         //实例化goods模型
         $goodsModel = new Goods();
         //实例化模型
        $goodsGalleryModel = new Goods_gallery();
        if(yii::$app->request->isPost){
            //接受数据并执行
            $goodsGalleryModel->load(yii::$app->request->post());
            //验证数据
            $goodsGalleryModel->validate();
            //保存数据
            $goodsGalleryModel->save();
            //将id赋值
            $goodsModel->id = $goodsGalleryModel->id;
            //提示信息
            yii::$app->session->setFlash('change','保存成功');
            //跳转页面
            $this->redirect(['goods/index']);
            //将模型返回到视图
        }
        return $this->render('path',['model'=>$goodsGalleryModel]);
}
//显示图片goods/show-logo
//public function actionShowLogo($id){
//    //从数据库查出数据显示页面
//    $datas = Goods_gallery::findOne([$id]);
//    //返回数据到视图页面
//    return $this->render('logo',['datas'=>$datas]);
//    }
    /*
     * 商品相册
     */
    public function actionShowLogo($id)
    {
        $goods = Goods::findOne([$id]);
        if($goods == null){
//            throw new yii\web\NotFoundHttpException('商品不存在');
        }
        return $this->render('gallery',['goods'=>$goods]);
    }
    //ajax删除图片
//    public function actionAjaxDel()
//    {
//        $model = Goods_category::findOne(['id'=>\Yii::$app->request->post('id')]);
//        if($model){
//            $model->delete();
//            return 'success';
//        }
//        return 'fail';
//    }
//===============图片插件========================
    //插件
//    public function actions() {
//        return [
//            's-upload' => [
//                'class' => UploadAction::className(),
//                'basePath' => '@webroot/upload',
//                'baseUrl' => '@web/upload',
//                'enableCsrf' => true, // default
//                'postFieldName' => 'Filedata', // default
//                //BEGIN METHOD
//                //'format' => [$this, 'methodName'],
//                //END METHOD
//                //BEGIN CLOSURE BY-HASH
//                'overwriteIfExist' => true,
////                'format' => function (UploadAction $action) {
////                    $fileext = $action->uploadfile->getExtension();
////                    $filename = sha1_file($action->uploadfile->tempName);
////                    return "{$filename}.{$fileext}";
////                },
//                //END CLOSURE BY-HASH
//                //BEGIN CLOSURE BY TIME
//                'format' => function (UploadAction $action) {
//                    $fileext = $action->uploadfile->getExtension();
//                    $filehash = sha1(uniqid() . time());
//                    $p1 = substr($filehash, 0, 2);
//                    $p2 = substr($filehash, 2, 2);
//                    //var_dump($p2);die;
//                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
//                },
//                //END CLOSURE BY TIME
//                'validateOptions' => [
//                    'extensions' => ['jpg', 'png'],
//                    'maxSize' => 1 * 1024 * 1024, //file size
//                ],
//                'beforeValidate' => function (UploadAction $action) {
//                    //throw new Exception('test error');
//                },
//                'afterValidate' => function (UploadAction $action) {},
//                'beforeSave' => function (UploadAction $action) {},
//                'afterSave' => function (UploadAction $action) {
////                    $action->output['fileUrl'] = $action->getWebUrl();
////                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
////                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
////                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
//                    //上传图片到其牛云
//                    $config = [
//                        'accessKey'=>'GyRNA6SodIxZNHPw96aZFSObOmpG40voayV_id3l',
//                        'secretKey'=>'uylLO4dTgS76_dc_s6D-oPxquLNbMDxy-bSB4mZJ',
//                        'domain'=>'http://ouk9h3ujg.bkt.clouddn.com',//测试域名
//                        'bucket'=>'yiishop',//存储空间名称
//                        'area'=>Qiniu::AREA_HUADONG//区域
//                    ];
//                    $qiniu = new Qiniu($config);
//                    $file = $action->getWebUrl();
//                    $qiniu->uploadFile($action->getSavePath(),$action->getWebUrl());//上传文件到七牛云存储
//                    $url = $qiniu->getLink($file);//根据文件名获取七
//                    var_dump($url);exit;
//                    $action->output['fileUrl'] = $url;//输出图片地址
//                },
//            ],
//        ];
//    }

//=======================
    public function actions() {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "http://admin.yii2shop.com",//图片访问路径前缀
                    "imagePathFormat" => "/upload/{yyyy}{mm}{dd}/{time}{rand:6}" ,//上传保存路径
                    "imageRoot" => \Yii::getAlias("@webroot"),
                ],
            ],
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
                'overwriteIfExist' => true,//如果文件已存在，是否覆盖
                /* 'format' => function (UploadAction $action) {
                     $fileext = $action->uploadfile->getExtension();
                     $filename = sha1_file($action->uploadfile->tempName);
                     return "{$filename}.{$fileext}";
                 },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },//文件的保存方式
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
                    $goods_id = \Yii::$app->request->post('goods_id');
                    if($goods_id){
                        //相册上传图片
                        $model = new Goods_gallery();
                        $model->goods_id = $goods_id;
                        $model->path = $action->getWebUrl();//
                        $model->save();
                        $action->output['fileUrl'] = $action->getWebUrl();
                        $action->output['id'] = $model->id;//图片的id
                    }else{
                        //添加商品
                        $action->output['fileUrl'] = $action->getWebUrl();//输出文件的相对路径
                    }


//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }
    //ajax删除图片
    public function actionAjaxDel()
    {
        $model = Goods_gallery::findOne(['id'=>\Yii::$app->request->post('id')]);
        if($model){
            $model->delete();
            return 'success';
        }
        return 'fail';
    }


    //测试ztree
    public function actionZtree(){
        //$this->layout = false;//不加载布局文件  $this->>renderPartial()
        $models = Goods_category::find()->select(['id','name','parent_id'])->asArray()->all();
        var_dump($models);
        [[],[],[]];//[{},{},{}]
        return $this->renderPartial('ztree',['models'=>$models]);
    }

}