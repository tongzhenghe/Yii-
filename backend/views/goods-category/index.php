<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/13
 * Time: 17:10
 */
?>
<h1>商品分类列表</h1>
<table class="table" style="text-align: center" border="1">
    <tr>
        <th style="text-align: center">商品分类名称</th>
        <th style="text-align: center">商品父ID</th>
        <th style="text-align: center">商品简介</th>
        <th colspan="2" style="text-align: center">操作</th>
    </tr>
    <?php foreach($datas as $data):?>
    <tr>
        <td><?=$data->name;?></td>
        <td><?=$data->parent_id;?></td>
        <td><?=$data->intro;?></td>
        <td><a href="<?=\yii\helpers\Url::to(['goods-category/edit','id'=>$data->id]);?>" class="btn btn-success">编辑</a>
            <a href="<?=\yii\helpers\Url::to(['goods-category/del','id'=>$data->id]);?>" class="btn btn-warning">删除</a></td>
    </tr>
    <?php endforeach;?>
    <a href="<?php echo \yii\helpers\Url::to(['goods-category/add']);?>"class="btn btn-default">添加</a>
</table>
<?php echo
\yii\widgets\LinkPager::widget([
    'pagination'=>$pager
]);


;?>