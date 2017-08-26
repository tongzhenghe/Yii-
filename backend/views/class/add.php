<div class="col-lg-4"style="background:gainsboro">
<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/11
 * Time: 14:03
 */
//实例化form表单
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'class_name');
echo \yii\bootstrap\Html::submitButton($model->getIsNewRecord()?'添加班级':'修改班级');
\yii\bootstrap\ActiveForm::end();
?>
</div>