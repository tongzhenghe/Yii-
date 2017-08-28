<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/18
 * Time: 15:01
 */

namespace backend\controllers;
use backend\models\Admin;
use backend\models\EditPermission;
use backend\models\Permission;
use backend\models\Role;
use yii\web\Controller;
use yii;
class RbacController extends Controller
{   //添加角色:rbac/add-rples
    public function actionAddRoles(){
        //实例化模型对象
        $roleModels = new Role();
        //接受数据并绑定表单验证数据
        if($roleModels->load(yii::$app->request->post())&&$roleModels->validate()){
            //保存树调用模型里面的save方法
            if($roleModels->save()){
                Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['role-list']);
            }else{
                var_dump($roleModels->getErrors());exit;
            }
        }
        //返回视图
        return $this->render('addRole',['model'=>$roleModels]);
    }
    //显示角色列表
    public function actionRoleList(){
        //查出所有角色
        $Roles = yii::$app->authManager->getRoles();
        //var_dump($Roles);die;
        //返回给视图
        return $this->render('roles',['roles'=>$Roles]);
    }
    //编辑角色
    //编辑角色
    public function actionEditRole($name){
        //获取角色
        $role = yii::$app->authManager->getRole($name);
        //实例化角色对象
        $roleModels = new Role();
        //$roleOne = yii::$app->authManager->getRole($name);
        //绑定表单&&验证数据
        if($roleModels->load(yii::$app->request->post())&&$roleModels->validate()){
            //获取name
            //调用模型方法编辑
            $roleModels->editRole($name);
            //保存数据
            //$roleModels->save();
            //提示信息
            Yii::$app->session->setFlash('success','编辑权限成功');
            //跳转页面
            return $this->redirect(['role-list']);
        }
        //将查出看来的角色赋值给表单对象属性
        $roleModels->name = $role->name;
        //将查出来的描述赋值给表单对象属性
        $roleModels->description = $role->description;
        //获取所有权限
        $permissions = yii::$app->authManager->getPermissionsByRole($name);
        //通过简明取出权限名称
        $permission = array_keys($permissions);
        //回显：将查出来的数据赋值给表单对象属性
        $roleModels->permissions = $permission;
        //将数据返回到视图
        return $this->render('addRole',['model'=>$roleModels]);
    }
    //删除角色
    public function actionDelRole($name){
        //实例化组件
        $authManager = yii::$app->authManager;
        //通过名称获取一个角色
        $roleObj = yii::$app->authManager->getRole($name);
        //移除角色
        $authManager->remove($roleObj);
        //提示信息
        Yii::$app->session->setFlash('success','删除成功');
        //跳转页面
        return $this->redirect(['role-list']);
    }
    //显示权限列表
    public function actionPermissionList(){
        //通过组件获取所有权限数据
        $permissionObjs = yii::$app->authManager->getPermissions();
        //返回给视图
        return $this->render('permission',['permissionObjs'=>$permissionObjs]);
    }
    //添加权限
    public function actionAddPermission(){
        //实例化权限模型对象
        $permissionModel = new Permission();
        //绑定表单&&验证数据
        if($permissionModel->load(yii::$app->request->post())&&$permissionModel->validate()){
            //保存数据
            if($permissionModel->save()){
                //提示信息
                Yii::$app->session->setFlash('success','添加权限成功');
                //跳转页面
                return $this->redirect(['permission-list']);
            }
        }
        //返回给视图
        return $this->render('addPermission',['model'=>$permissionModel]);
    }
    //编辑权限列表
    public function actionEditPermission($name){
        $authmanager = yii::$app->authManager;//实例化组件
        $permissionObj = yii::$app->authManager->getPermission($name);//通过名称获取一条数据
        $model = new Permission();   //实例化模型对象
        if(yii::$app->request->isPost){//判定是否为post接受数据
            if($model->load(yii::$app->request->post())){//执行
                if($model->validate()){//验证数据合法性
                    if($model->name==$permissionObj->name||$model->description==$permissionObj->description){//因为是修改，所以数据库里面本身存在，所以不能直接通过是否存在来判定。因为一致存在
                        $model->addError('name','权限名已存在');//提示信息
                        $model->addError('description','权限描述不能同名');//提示信息
                    }else{
                        $permissionObj->name = $model->name;//赋值
                        $permissionObj->description = $model->description;//赋值
                        $authmanager->update($name,$permissionObj);//修改
                        Yii::$app->session->setFlash('success','编辑成功');
                        return $this->redirect(['permission-list']);
                    }
                }
            }
        }
        //权限回显
        $model->description =  $permissionObj->description;
        $model->name = $permissionObj->name;
        //返回到视图
        return $this->render('editpermission',['model'=>$model]);
    }
    //删除权限
    public function actionDelPermission($name){
        //实例化组件
        $authManager = yii::$app->authManager;
        //获取当前对像
        $permissionObj = yii::$app->authManager->getPermission($name);
        //遗除
        $authManager->remove($permissionObj);
        //跳转
        Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['permission-list']);
    }
 }