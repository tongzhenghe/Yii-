<h1>商品添加</h1>
<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/14
 * Time: 16:39
 */
use yii\web\JsExpression;
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'goods_category_id')->hiddenInput();
$zTree = \backend\widgets\ZTreeWidget::widget([
    'setting'=>'{
    data: {
		simpleData: {
			enable: true,
			pIdKey: "parent_id",
		}
	},
	callback: {
		onClick: function(event, treeId, treeNode) {
            $("#goods-goods_category_id").val(treeNode.id);
        }
	}
}',
    'zNodes'=>\backend\models\Goods_category::getGoodsCategory(),
    'selectNodes'=>['id'=>$model->goods_category_id],
]);
echo '<div>
    <ul id="treeDemo" class="ztree"></ul>
</div>';
echo $form->field($model,'brand_id')->dropDownList(\backend\models\Goods::getAddBrand());;
echo $form->field($model,'market_price');
echo $form->field($model,'shop_price');
echo $form->field($model,'stock');
echo $form->field($model,'is_on_sale')->radioList([1=>'在售',0=>'下架']);
echo $form->field($model,'status')->radioList([1=>'正常', 0=>'回收站']);;
echo $form->field($model,'sort');
echo $form->field($intromodel,  'content')->widget(\crazydb\ueditor\UEditor::className());
echo $form->field($model,'logo')->hiddenInput();
//==============上传文件插件=============
//上传文件插件
//外部TAG
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \flyok666\uploadifive\Uploadifive::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'formData'=>['someKey' => 'someValue'],
        'width' => 80,
        'height' => 30,
        'onError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadComplete' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
//        图片回显
        $("#img").attr("src",data.fileUrl);
       
        //将图片地址写入到隐藏与输入框
        $("#goods-logo").val(data.fileUrl);
    }
}
EOF
        ),
    ]
]);
echo \yii\bootstrap\Html::img($model->logo,['id'=>'img']);
//===================END=====================
 echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-change']);
\yii\bootstrap\ActiveForm::end();


//===================无限极分类====================================
$zNodes = \backend\models\Goods_category::getGoodsCategory();

//加载ztree的静态资源
//加载css文件
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
//加载js文件   //depends 依赖关系
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
//加载js代码
$this->registerJs(new \yii\web\JsExpression(
    <<<JS
 var zTreeObj;
        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
        var setting = {
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent_id",
                    rootPId: 0
                }
            },
            callback:{
                onClick:function(event, treeId, treeNode){
                    console.log(treeNode.id);
                    //赋值给parent_id
                    $("#goods-goods_category_id").val(treeNode.id);
                }
            }
        };
        
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
       var zNodes = {$zNodes};
 
        
       zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
       //展开所有节点
       zTreeObj.expandAll(true);
        //修改功能   根据当前分类的parent_id选中节点
    
       // zTreeObj.selectNode(node);
       
JS
));
//===================无限极分类====================================