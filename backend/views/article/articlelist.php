<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/10
 * Time: 23:36
 */
?>
<a href="<?=yii\helpers\Url::to(['article/add'])?>" class="btn btn-primary"><strong>添加文章</strong></a>
<table class="table" border="1" style="text-align: center; background: lightgrey">
    <tr>
        <td>文章名称</td>
        <td>文章排序</td>
        <td>上线状态</td>
        <td>文章简介</td>
        <td>类别</td>
        <td>头像</td>
        <td colspan="2">操作</td>
    </tr>
    <?php foreach($shuju as $val):;?>

    <tr>
        <td><?=$val->name;?></td>
        <td><?=$val->sort?></td>
        <td><?=$val->status?></td>
        <td><?=$val->intro?></td>
        <td><?=$val->articleCategory->name;?></td>
        <td><?php echo "<img src=".$val->photo." style='width: 200px'/>"?></td>
        <td><a href="<?php echo yii\helpers\Url::to(['article/content','id'=>$val['article_category_id']]);?>" class="btn btn-success">内容</a>
            <a href="<?php echo yii\helpers\Url::to(['article/del','id'=>$val->id]);?>" class="btn btn-danger">删除</a>
            <a href="<?php echo yii\helpers\Url::to(['article/edit','id'=>$val->id]);?>" class="btn btn-warning">编辑</a>
        </td>
    </tr>
    <?php Endforeach;?>
</table>
<?php echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
])?>

