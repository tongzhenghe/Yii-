<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/12
 * Time: 22:56
 */
?>
<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['article_category/add']);?>">添加</a>
<table class="table" border="1" style="text-align: center">
    <tr>
        <td>ID</td>
        <td>分类名称</td>
        <td>分类简介</td>
        <td>分类排序</td>
        <td>分类状态</td>
        <td>操作</td>
    </tr>
    <?php foreach($data as $key=>$val):?>
    <tr>
        <td><?=$val->id?></td>
        <td><?=$val->name?></td>
        <td><?=$val->intro?></td>
        <td><?=$val->sort?></td>
        <td><?=$val->status?></td>
        <td><a class="btn btn-primary"  href="<?php echo  \yii\helpers\Url::to(['article_category/edit']).'?id='.$val->id;?>">编辑</a>
       <a class="btn btn-danger" href="<?php echo  \yii\helpers\Url::to(['article_category/del']).'?id='.$val->id;?>">删除</a></td>
    </tr>
    <?php Endforeach;?>
</table>
