<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/18
 * Time: 15:56
 */
/**
 * @var $this yii\web\View
 */
?>
<a href="<?php echo \yii\helpers\Url::to(['add-permission']);?>" class="btn btn-info">添加权限</a></td>

<table id="table_id_example" class="display">
    <thead>
    <tr>
        <th>权限名称</th>
        <th>权限描述</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($permissionObjs as $permissionObj):?>
      <tr>
        <td><?=$permissionObj->name?></td>
        <td><?=$permissionObj->description?></td>
        <td><a href="<?php echo \yii\helpers\Url::to(['del-permission','name'=>$permissionObj->name])?>" class="btn btn-danger">删除</a>
             <a href="<?php echo \yii\helpers\Url::to(['edit-permission','name'=>$permissionObj->name])?>" class="btn btn-info">编辑</a></td>
    </tr>
<?php Endforeach;?>
    </tbody>
</table>
<?php
//加载js和css
$this->registerCssFile('@web/data-tables/media/css/jquery.dataTables.css');
$this->registerJsFile('@web/data-tables/media/js/jquery.dataTables.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs(<<<JS
    $(document).ready( function () {
        $('#table_id_example').DataTable({
            language: {
                "sProcessing": "处理中...",
                "sLengthMenu": "显示 _MENU_ 项结果",
                "sZeroRecords": "没有匹配结果",
                "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                "sInfoPostFix": "",
                "sSearch": "搜索:",
                "sUrl": "",
                "sEmptyTable": "表中数据为空",
                "sLoadingRecords": "载入中...",
                "sInfoThousands": ",",
                "oPaginate": {
                "sFirst": "首页",
                "sPrevious": "上页",
                "sNext": "下页",
                "sLast": "末页"
                },
                "oAria": {
                "sSortAscending": ": 以升序排列此列",
                "sSortDescending": ": 以降序排列此列"
                }
                }
        });
    } );
JS
);
?>