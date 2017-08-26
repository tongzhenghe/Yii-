<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/10
 * Time: 16:51
 */
?>
<a href="<?=\yii\helpers\Url::to(['brand/add']);?>" class="btn btn-default">添加</a>
<table class="table" border="1" style="text-align: center">
    <tr>
        <td>品牌名称</td>
        <td>排序</td>
        <td>状态</td>
        <td>简介</td>
        <td>LOGO</td>
        <td colspan="2">操作</td>
    </tr>
    <?php foreach($shuju as $key=>$val):?>
    <tr>
        <td><?=$val['name']?></td>
        <td><?=$val['sort']?></td>
        <td><?=$val['status']?></td>
        <td><?=$val['intro']?></td>
        <td><img src="<?=$val['logo'];?>"></td>
        <td><a href="<?=\yii\helpers\Url::to(['brand/del']),'?id='.$val['id'];?>" class="btn btn-danger">删除</a></td>
       <td><a href="<?=\yii\helpers\Url::to(['brand/edit']),'?id='.$val['id'];?>" class="btn btn-info">编辑</a></td>
    </tr>
    <?php Endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget([
        'pagination'=>$pager
//        'maxBottonCount'=>5,
//    'hideOnSinglePage' => false
])?>
