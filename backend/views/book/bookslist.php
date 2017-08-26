<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/11
 * Time: 20:50
 */
?>
<a class="btn btn-link" href="<?php echo \yii\helpers\Url::to(['book/add'])?>" class="btn btn-default">添加</a>
<table class="table" border="1" style="text-align: center">
    <tr>
        <th style="text-align: center">图书标题</th>
        <th style="text-align: center">添加时间</th>
        <th style="text-align: center">所属学生</th>
        <th style="text-align: center">简介</th>
<!--        <td>LOGO</td>-->
        <th colspan="2" style="text-align: center">操作</th>
    </tr>
    <?php foreach ($shuju as $val):?>

    <tr>
        <td><?=$val['title'];?></td>
        <td><?=$val['addTime'];?></td>
        <td><?=$val['name'];?></td>
        <td><?=$val['intro'];?></td>
        <td><img src="<?=$val['logo'];?>" style="width:100px"></td>
        <td><a class="btn btn-link" href="<?php echo \yii\helpers\Url::to(['book/edit']).'?id='.$val['id'];?>">编辑</a>
            <a class="btn btn-link" href="<?php echo \yii\helpers\Url::to(['book/del']).'?id='.$val['id'];?>">删除</a></td>
    </tr>
    <?php Endforeach;?>
</table>
<?php echo exit;?>













