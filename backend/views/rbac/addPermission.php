<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/18
 * Time: 16:13
 */
$form =\yii\widgets\ActiveForm::begin();
echo $form->field($model,'name');//角色名称
echo $form->field($model,'description');//描述
echo \yii\helpers\Html::submitButton(   '添加权限',['class'=>'default']);
\yii\widgets\ActiveForm::end();