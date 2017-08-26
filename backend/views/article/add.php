
<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/10
 * Time: 23:57
 */
//实例化form表单
use yii\web\JsExpression;
$form = \yii\bootstrap\ActiveForm::begin();
//echo "<div class='col-lg-4'>";
echo $form->field($model,'name')->textInput();
echo $form->field($model,'sort')->textInput();
echo $form->field($model,'status')->radioList([0=>'隐藏',1=>"上架"]);
echo $form->field($model,'intro')->textInput();
echo $form->field($model,'content')->textarea();
//$data = \yii\helpers\ArrayHelper::map($article_category,'id','name');
echo $form->field($model,'article_category_id')->dropDownList(\yii\helpers\ArrayHelper::map($article_category,'id',array('name')));
echo $form->field($model,'photo')->hiddenInput();
//====================================================
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
        //图片回显
        $("#img").attr("src",data.fileUrl);
        
        //将图片地址写入到隐藏与输入框
        $("#article-photo").val(data.fileUrl);
    }
}
EOF
        ),
    ]
]);
echo \yii\bootstrap\Html::img($model->photo,['id'=>'img']);
echo \yii\bootstrap\Html::submitButton($model->getIsNewRecord()?'添加文章':'编辑文章',['class'=>'btn btn-change']);
//echo "<div/>";
\yii\bootstrap\ActiveForm::end();
