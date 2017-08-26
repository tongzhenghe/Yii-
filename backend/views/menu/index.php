<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/20
 * Time: 11:55
 */
?>
<h1>添加菜单</h1>
<a class="btn btn-success"  href="<?php echo \yii\helpers\Url::to(['add']);?>">添加</a>
<table class="table" border="1" style="text-align: center">
    <tr>
        <th style="text-align: center">菜单名称</th>
        <th style="text-align: center">路由</th>
        <th style="text-align: center">排序</th>
        <th style="text-align: center">操作</th>
    </tr>
    <?php foreach($menus as $menu):?>
    <tr>
        <td><?=$menu->name?></td>
        <td><?=$menu->url;?></td>
        <td><?=$menu->sort?></td>
        <td><a class="btn btn-primary"  href="<?php echo \yii\helpers\Url::to(['del','id'=>$menu->id]);?>">删除</a>
            <a  class="btn btn-success"  href="<?php echo \yii\helpers\Url::to(['edit','id'=>$menu->id]);?>">编辑</a>
        </td>
    </tr>
    <?php Endforeach;?>
</table>
<?php echo  \yii\widgets\LinkPager::widget([
        'pagination'=>$page,
    ]);?>
