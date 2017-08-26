    <?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/19
 * Time: 14:21
 */
?>
    <a href="<?php echo \yii\helpers\Url::to(['add-roles'])?>" class="btn btn-warning">添加角色</a>
    <table class="table">
        <tr>
            <th>角色名称</th>
            <th>角色描述</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
        <?php foreach($roles as $role):?>
        <tr>
            <td><?php echo $role->name;?></td>
            <td><?php echo $role->description;?></td>
            <td><?php echo $role->createdAt;?></td>
            <td><?php echo $role->updatedAt;?></td>
            <td><a href="<?php echo \yii\helpers\Url::to(['edit-role','name'=>$role->name]);?>" class="btn btn-success">编辑</a>
                <a href="<?php echo \yii\helpers\Url::to(['del-role','name'=>$role->name]);?>" class="btn btn-success">删除</a></td>
        </tr>
        <?php Endforeach;?>
    </table>










