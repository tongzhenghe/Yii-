<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/11
 * Time: 16:28
 */
?>
<a href="<?=\yii\helpers\Url::to(['student/add']);?>">添加学生</a>
<table class="table" border="1" style="text-align: center">
    <tr>
        <th style="text-align: center">学生姓名</th>
        <th style="text-align: center">年龄</th>
        <th style="text-align: center">性别</th>
        <th style="text-align: center">所属班级</th>
        <th colspan="2" style="text-align: center">操作</th>
    </tr>
    <?php foreach($shuju as $key=>$val):?>
    <tr>
        <td><?=$val['name']?></td>
        <td><?=$val['age']?></td>
        <td><?=$val['sex']?></td>
        <td><?=$val['class_id']?></td>
        <td><a href="<?=\yii\helpers\Url::to(['student/del']).'?student_id='.$val['student_id']?>">删除</a>
        <a href="<?=\yii\helpers\Url::to(['student/edit']).'?student_id='.$val['student_id']?>">编辑</a></td>
    </tr>
    <?php Endforeach;?>
</table>
<?php //echo \yii\widgets\LinkPager::widget([
//   'pagination'=>$pager,
//]);?>
