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
echo $form->field($model,'student_id')->dropDownList(\yii\helpers\ArrayHelper::map($shuju,'student_id',array('name')));
echo $form->field($model,'imgFile')->fileInput();
echo \yii\helpers\Html::submitButton('添加图书');
\yii\bootstrap\ActiveForm::end();
echo "</div>";