<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/11
 * Time: 13:52
 */
?>
<div style="background:gainsboro">
<div class="btn btn-default"><a href="<?php echo \yii\helpers\Url::to(['class/add']);?>">添加班级</a></div>
<table border="1" class="table" style="text-align: center">
    <tr>
        <th style="text-align: center">班级编号</th>
        <th style="text-align: center">班级名称</th>
        <th colspan="2" style="text-align: center">操作</th>
    </tr>
    <?php foreach($shuju as $key=>$val):;?>
    <tr>
        <td><?=$val['class_id']?></td>
        <td><?=$val['class_name']?></td>
        <td>
            <div class="btn btn-success"><a href="<?php echo \yii\helpers\Url::to(['class/edit']).'?class_id='.$val['class_id'];?>">编辑</a></div>
                <div class="btn btn-warning">  <a href="<?php echo \yii\helpers\Url::to(['class/del']).'?class_id='.$val['class_id'];?>">删除</a></div>
        </td>
    </tr>
    <?php Endforeach;?>
</table>
</div>
<?=\yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
        //'maxBottonCount'=>5,
    'hideOnSinglePage' => false
])?>