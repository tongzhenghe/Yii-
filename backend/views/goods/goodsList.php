<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/14
 * Time: 14:44
 */
?>
<!--goods商品列表显示：
name	varchar(20)	商品名称
sn	varchar(20)	货号
logo	varchar(255)	LOGO图片
goods_category_id	int	商品分类id（链表嵌套goods_category）
brand_id	int	品牌分类（brand表）（链表嵌套）
market_price	decimal(10,2)	市场价格
shop_price	decimal(10, 2)	商品价格
stock	int	库存
is_on_sale	int(1)	是否在售(1在售 0下架)
status	inter(1)	状态(1正常 0回收站)
sort	int()	排序
create_time	int()	添加时间-->
<label class="btn" style="font-size: 20px">Goods商品列表显示</label><br/>
<form  action="<?php echo \yii\helpers\Url::to(['goods/index']);?>" method="get"  class="navbar-form navbar-left">

        <input type="text" class="form-control" name="name"  placeholder="请输入关键字">

    <button type="submit" class="btn btn-default">搜索</button>
</form>
<a class="btn btn-danger" href="<?php echo \yii\helpers\Url::to(['goods/add']);?>" style="font-size: 20px;">添加商品</a>
<table class="table"  border="1" style="text-align: center">
    <tr>
        <th class="success" style="text-align: center">商品名称</th>
        <th class="success"style="text-align: center">货号</th>
        <th class="success"style="text-align: center">商品分类</th>
        <th class="success"style="text-align: center">品牌分类</th>
        <th class="success"style="text-align: center">市场价格</th>
        <th class="success"style="text-align: center">商品价格</th>
        <th class="success"style="text-align: center">库存</th>
        <th class="success"class="warning" style="text-align: center">是否在售</th>
        <th class="success"style="text-align: center">状态</th>
        <th class="success" style="text-align: center">排序</th>
        <th class="success" style="text-align: center">添加时间</th>
        <th  class="success"style="text-align: center">LOGO图片</th>
        <td  class="success"style="text-align: center;">操作</td>
    </tr>
    <?php foreach($datas as $data):;?>
    <tr>
        <td  class="info"><?=$data->name;?></td>
        <td class="info"><?=$data->sn;?></td>
        <td  class="info"><?=$data->goodsCategory->name;?></td>
        <td  class="info"><?=$data->brand->name;?></td>
        <td  class="info"><?=$data->market_price;?></td>
        <td  class="info"><?=$data->shop_price;?></td>
        <td  class="info"><?=$data->stock;?></td>
        <td  class="info"><?=$data->is_on_sale;?></td>
        <td  class="info"><?=$data->status;?></td>
        <td  class="info"><?=$data->sort;?></td>
        <td  class="info"><?=$data->create_time;?></td>
        <td  class="info"><img src="<?=$data->logo;?>" style="width: 100px"></td>
        <td  class=""><a href="<?php echo \yii\helpers\Url::to(['show-logo','id'=>$data['id']]);?>" class="btn btn-default" style="font-size: 17px;">相册</a>
            <a href="<?php echo \yii\helpers\Url::to(['goods/edit','id'=>$data['id']]);?>"  class="btn btn-success" style="font-size: 17px">编辑</a>
            <a href="<?php echo \yii\helpers\Url::to(['goods/del','id'=>$data['id']]);?>" class="btn btn-danger" style="font-size: 17px">删除</a></td>
    </tr>
    <?php Endforeach;?>
</table>
<?php echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
]);
;?>

