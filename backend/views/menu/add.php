<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/18
 * Time: 16:13
 */

$form =\yii\widgets\ActiveForm::begin();
echo $form->field($model,'name');//角色名称
echo $form->field($model,'parent_id')->dropDownList(\backend\models\Menu::getMenu());//角色名称
echo $form->field($model,'url')->dropDownList(\backend\models\Menu::getPermissions());//描述
echo $form->field($model,'sort');//角色名称
echo \yii\helpers\Html::submitButton(   '添加菜单',['class'=>'btn btn-success']);
\yii\widgets\ActiveForm::end();