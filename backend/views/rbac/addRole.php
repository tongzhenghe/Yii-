<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/18
 * Time: 15:12
 */
$form =\yii\widgets\ActiveForm::begin();
echo $form->field($model,'name');//角色名称
echo $form->field($model,'description');//描述
echo $form->field($model,'permissions')->checkboxList(\backend\models\Role::getPerssions());//角色权限
echo \yii\helpers\Html::submitButton('添加角色',['class'=>'default']);
\yii\widgets\ActiveForm::end();