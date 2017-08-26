<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/11
 * Time: 21:07
 */
//实例化form表单
echo "<div class='col-lg-4'>";
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'title')->textInput();
echo $form->field($model,'intro')->textInput();
echo $form->field($model,'imgFile')->fileInput();
echo "<img src='$model->logo'/>";
echo \yii\helpers\Html::submitButton('编辑图书');
\yii\bootstrap\ActiveForm::end();
echo "</div>";