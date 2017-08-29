<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/18
 * Time: 15:05
 */

namespace backend\models;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class Role extends  Model
{
    public $name;//角色名称
    public $description;//描述
    public $permissions;//权限
    public function rules()
    {
        return [
            [['name','description'],'required'],
            [['permissions'],'safe']
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'角色名称',
            'description'=>'描述',
            'permissions'=>'权限'
        ];
    }
    //创建角色方法
    public function save(){

        //实例化authmanger组件
        $authManger = \yii::$app->authManager;

        //获取角色
        if($authManger->getRole($this->name)){
            //返回错误信息
            $this->addError('name','角色已存在');
            return false;
        }else{
            //创建角色
            $role = $authManger->createRole($this->name);
            //为角色添加描述
            $role->description = $this->description;
            //保存角色到数据库
            $authManger->add($role);
            //判定权限是否为数组类型（如果选择权限则为数组类型，不选为字符串）
            if(is_array($this->permissions)){//如果给定权限存在就遍历（为数组）没有就不遍历（字符串）
                foreach ($this->permissions as $permissionName){
                    //获取权限
                    $permission = $authManger->getPermission($permissionName);
                    //var_dump($permission);die;
                    //为角色加权限
                    $authManger->addChild($role,$permission);
                }
            }
            return true;
        }
    }
    //编辑功能
    public function editRole($name){
        //实例化authmanger组件
        $authManger = \yii::$app->authManager;
        //获取角色
        if($authManger->getRole($this->name)){
            //返回错误信息
            $this->addError('name','角色已存在');
            return false;
        }else{
            //创建角色
            $role = $authManger->createRole($this->name);
            //为角色添加描述
            $role->description = $this->description;
            //保存角色到数据库
            $authManger->update($name,$role);
            //判定权限是否为数组类型（如果选择权限则为数组类型，不选为字符串）
            if(is_array($this->permissions)){//如果给定权限存在就遍历（为数组）没有就不遍历（字符串）
                foreach ($this->permissions as $permissionName){
                    //获取权限
                    $permission = $authManger->getPermission($permissionName);
                    //var_dump($permission);die;
                    //为角色加权限
                    $authManger->addChild($role,$permission);
                }
            }
            return true;
        }
    }
    public static function getPerssions(){
        //获取所有权限
       $perssions = \yii::$app->authManager->getPermissions();
       //返回视图
       return ArrayHelper::map($perssions,'name','description');
   }
}










