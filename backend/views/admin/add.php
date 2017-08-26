<?php
/**
'username'=>$this->string(30)->notNull()->unique()->comment('用户名'),
'auth_key' => $this->string(32)->notNull()->comment('验证码'),
'password_hash' => $this->string(100)->notNull()  ->comment('用户密码'),
'password_reset_token' => $this->string(100)->unique()->comment('重置密码'),
'email' => $this->string(100)->notNull()->unique()->comment('邮箱'),
'status' => $this->smallInteger(2)->notNull()->defaultValue(10)->comment('状态'),
'created_at' => $this->integer()->notNull()->comment('创建时间'),
'updated_at' => $this->integer()->notNull()->comment('修改时间'),
'last_login_ip'=>$this->integer()->notNull()->comment('最后登录IP')
 */

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'email')->textInput();
echo $form->field($model,'roles')->checkboxList(\backend\models\Admin::getRoles());//描述
echo $form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'禁用']);
echo \yii\helpers\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();