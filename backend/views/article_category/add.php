<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/12
 * Time: 23:11
 */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'sort')->textInput();
echo $form->field($model,'status')->radioList([1=>'正常',0=>'隐藏']);
echo \yii\bootstrap\Html::submitButton($model->getIsNewRecord()?'添加分类':'编辑分类',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();