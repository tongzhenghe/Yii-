<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/11
 * Time: 16:43
 */
//实例化表单
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'age')->textInput();
echo $form->field($model,'sex')->radioList(['男','女']);
echo $form->field($model,'class_id')->dropDownList(\yii\helpers\ArrayHelper::map($shuju,'class_id',array('class_name')));
echo \yii\bootstrap\Html::submitButton('添加学生');
\yii\bootstrap\ActiveForm::end();