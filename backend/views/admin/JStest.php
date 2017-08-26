
//得到id。点击事件控制器里面的方法。
<button  id="<?=$parmission->name?>" onclick="delpar(admin/add)" class="btn btn-xs btn-danger glyphicon glyphicon-trash">删除</button>

<script type="text/javascript">
    //声明名一个删除的函数
    function delpar(name) {
        console.log(name);
        //弹窗提示是否删除
        //返回true表示删除
        if (confirm("删除?")){
            //利用Ajax请求根据id删除数据
            $.getJSON("http://admin.yiishop.com/rbac/parmissiondel","name="+name+"",function (data){
//                console.log(data);

                //判定数据库是否删除成功成功返回1
//                if (data === 1){
//                    //根据id获取对应的父节点并删除
//                    $("#"+name+"").parent().parent().remove();
//                }
            })
        }

    }

</script>

