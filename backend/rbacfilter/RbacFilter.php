<?php
namespace backend\rbacfilter;
use yii\web\HttpException;

/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/20
 * Time: 18:51
 */
class RbacFilter extends \yii\base\ActionFilter
{
    //声明过滤器方法
    public function beforeAction($action)
    {   //根据当前id限制访问权限
        if(!\yii::$app->user->can($action->uniqueId)){//判定只允许访问给定的权限
            //判定是否为游客
            if(\yii::$app->user->isGuest){
                //跳转到登陆页面
                return $action->controller->redirect(\yii::$app->user->loginUrl)->send();
            }
//            提示信息
            throw new HttpException(403,'对不起!您没有权限访问此页面，请联系管理员！');
        }
        //拦截 禁止访问
        //return false;//禁止
        //return true;//放行
        return parent::beforeAction($action);
    }
}