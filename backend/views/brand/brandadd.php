<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/10
 * Time: 17:25
 */
?>

<?php
use yii\web\JsExpression;
//实例化form表单
$form =\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'sort');
echo $form->field($model,'status')->radioList([0=>'隐藏',1=>'正常']);
echo $form->field($model,'logo')->hiddenInput();
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
        $("#brand-logo").val(data.fileUrl);
       
    }
}
EOF
        ),
    ]
]);
//echo "<img src='$mode'/>";
echo $form->field($model,'intro')->textInput();
echo \yii\bootstrap\Html::img($model->logo,['id'=>'img']);
echo \yii\bootstrap\Html::submitButton($model->getIsNewRecord()?'添加品牌':'编辑品牌',['class'=>'btn btn-primary']);
\yii\bootstrap\ActiveForm::end();


?>
