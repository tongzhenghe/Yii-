<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/12
 * Time: 20:39
 */

namespace backend\models;


use yii\db\ActiveRecord;

class Article_detail extends ActiveRecord
{
    public function rules()
    {
        return [
            [['content'],'required']
        ]; // TODO: Change the autogenerated stub
    }
    public function attributeLabels()
    {
        return [

            'content'=>'文章内容'

        ]; // TODO: Change the autogenerated stub
    }

}