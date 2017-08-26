<?php
use flyok666\uploadifive\Uploadifive;
use yii\bootstrap\Html;
use yii\web\JsExpression;


echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \flyok666\uploadifive\Uploadifive::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'formData'=>['goods_id' => $goods->id],//参数
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
    //console.log(data);
    if (data.error) {
        alert(data.msg);
    } else {
        console.log(data.fileUrl);
        //将图片的地址赋值给logo字段
        //$("#goods-logo").val(data.fileUrl);
        //将上传成功的图片回显
        //$("#img").attr('src',data.fileUrl);
        $("#gallery").append('<tr data-id="'+data.id+'"><td><img src="'+data.fileUrl+'" /></td><td><button type="button" class="btn btn-danger del_btn">删除</button></td></tr>');
    }
}
EOF
        ),
    ]
]);
?>
    <table id="gallery" class="table table-responsive table-bordered">
        <tr>
            <th>图片</th>
            <th>操作</th>
        </tr>
        <?php foreach($goods->galleries as $gallery):?>
            <tr data-id="<?=$gallery->id?>">
                <td><?=Html::img($gallery->path)?></td>
                <td><?=Html::button('删除',['class'=>'btn btn-danger del_btn'])?></td>
            </tr>
        <?php endforeach;?>

    </table>
<?php
/**
 * @var $this \yii\web\View
 */
$url = \yii\helpers\Url::to(['ajax-del']);
//删除图片
$this->registerJs(new JsExpression(
    <<<JS
    $("#gallery").on('click','.del_btn',function(){
    //$(".del_btn").click(function(){
        if(confirm('是否确认删除该图片？！')){
            var tr = $(this).closest('tr');
            //发起ajax请求，删除数据表记录
            var id = tr.attr('data-id');
            $.post("{$url}",{id:id},function(data){
                if(data=='success'){
                    tr.remove();//移除图片所在tr
                }else{
                    console.log(data);
                }
            });
        }
        
    });
JS
));
//$this->registerJs('');
//use yii\web\JsExpression;
//
////================上传文件插件========
////上传文件插件
////外部TAG
//$form = \yii\bootstrap\ActiveForm::begin();
//
//echo $form->field($model,'path')->hiddenInput();
//echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
//echo \flyok666\uploadifive\Uploadifive::widget([
//    'url' => yii\helpers\Url::to(['s-upload']),
//    'id' => 'test',
//    'csrf' => true,
//    'renderTag' => false,
//    'jsOptions' => [
//        'formData'=>['goods_id' => $goods->id],//参数
//        'width' => 80,
//        'height' => 30,
//        'onError' => new JsExpression(<<<EOF
//function(file, errorCode, errorMsg, errorString) {
//    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
//}
//EOF
//        ),
//        'onUploadComplete' => new JsExpression(<<<EOF
//function(file, data, response) {
//    data = JSON.parse(data);
//    if (data.error) {
//        console.log(data.msg);
//    } else {
//        console.log(data.fileUrl);
//        //图片回显
//        $("#img").attr("src",data.fileUrl);
//
//        //将图片地址写入到隐藏与输入框
//        $("#goods_gallery-path").val(data.fileUrl);
//    }
//}
//EOF
//        ),
//    ]
//]);
//echo \yii\bootstrap\Html::img($model->path,['id'=>'img']);
//echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-change']);
//\yii\bootstrap\ActiveForm::end();
//
//
//
//
//
//
//
