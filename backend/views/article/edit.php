<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/11
 * Time: 10:11
 */
//实例化form表单
$form = \yii\bootstrap\ActiveForm::begin();
//echo "<div class='col-lg-4'>";
echo $form->field($model,'name')->textInput();
echo $form->field($model,'sort')->textInput();
echo $form->field($model,'status')->radioList([0=>'隐藏',1=>"上架"]);
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'imgFile')->fileInput();
echo "<img src='$model->photo' style='width: 150px'/>";echo"<br/>";
echo \yii\bootstrap\Html::submitButton('编辑文章');

//echo "<div/>";
\yii\bootstrap\ActiveForm::end();
