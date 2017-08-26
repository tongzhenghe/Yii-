<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/11
 * Time: 16:43
 */
//实例化表单
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->dropDownList($model->test);
echo $form->field($model,'intro')->textInput();
echo $form->field($model,'parent_id');
echo \yii\bootstrap\Html::submitButton('添加');
\yii\bootstrap\ActiveForm::end();