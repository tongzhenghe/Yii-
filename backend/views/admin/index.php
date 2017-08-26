<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/16
 * Time: 12:50
 *     'username'=>$this->string(30)->notNull()->unique()->comment('用户名'),
'auth_key' => $this->string(32)->notNull()->comment('验证码'),
'password_hash' => $this->string(100)->notNull()  ->comment('用户密码'),
'password_reset_token' => $this->string(100)->unique()->comment('重置密码'),
'email' => $this->string(100)->notNull()->unique()->comment('邮箱'),
'status' => $this->smallInteger(2)->notNull()->defaultValue(10)->comment('状态'),
'created_at' => $this->integer()->notNull()->comment('创建时间'),
'updated_at' => $this->integer()->notNull()->comment('修改时间'),
'last_login_ip'=>$this->integer()->notNull()->comment('最后登录IP')
 */
?>
<a href="<?php echo \yii\helpers\Url::to(['add']);?>" class="btn btn-info">添加管理员</a>
<table class="table">
    <tr>
        <th>用户名</th>
        <th>邮箱</th>
        <th>状态</th>
        <th>用户创建时间</th>
        <th>更改用户时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($admins as $admin):;?>
    <tr>
        <td><?=$admin->username;?></td>
        <td><?=$admin->email;?></td>
        <td><?php if($admin->status=1){
            echo '使用中';
            }else{
            echo '已弃用';
            };?></td>
        <td><?=$admin->created_at;?></td>
        <td><?=$admin->updated_at;?></td>
        <td><a href="<?php echo \yii\helpers\Url::to(['del','id'=>$admin->id]);?>" class="btn btn-warning">删除</a>
            <a href="<?php echo \yii\helpers\Url::to(['edit','id'=>$admin->id]);?>" class="btn btn-success">编辑</a></td>
    </tr>
    <?php Endforeach;?>
    <a href="<?php echo \yii\helpers\Url::to(['logout']);?>" class="btn btn-info">退出登陆</a>
    <a href="<?php echo \yii\helpers\Url::to(['change-password']);?>" class="btn btn-info">修改密码</a>
</table>
<!--<div id="box">-->
<?php echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
])?>
