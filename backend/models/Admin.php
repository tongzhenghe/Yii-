<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/16
 * Time: 11:36
 */

namespace backend\models;


use Faker\Provider\DateTime;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/*    'username'=>$this->string(30)->notNull()->unique()->comment('用户名'),
    'auth_key' => $this->string(32)->notNull()->comment('验证码'),
    'password_hash' => $this->string(100)->notNull()  ->comment('用户密码'),
    'password_reset_token' => $this->string(100)->unique()->comment('重置密码'),
    'email' => $this->string(100)->notNull()->unique()->comment('邮箱'),
    'status' => $this->smallInteger(2)->notNull()->defaultValue(10)->comment('状态'),
    'created_at' => $this->integer()->notNull()->comment('创建时间'),
    'updated_at' => $this->integer()->notNull()->comment('修改时间'),
    'last_login_ip'=>$this->integer()->notNull()->comment('最后登录IP')*/
class Admin extends ActiveRecord implements IdentityInterface
{
    public $roles;//用户权限
    public $name;
    public $password;
    public $user_id;
    public function rules()
    {
        return [
            [['username', 'email', 'updated_at', 'status'], 'required'],//添加功能
            [['status', 'created_at', 'last_login_time', 'last_login_ip'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['password'], 'string'],
            [['auth_key'], 'string', 'max' => 4334],
            [['username'], 'unique'],//唯一性验证
            [['email'], 'unique'],
            [['email'], 'email'],//验证email
            [['roles'], 'safe']
        ];
    }
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'email' => '邮箱',
            'status' => '状态',
            'roles' => '用户角色',
            'last_login_ip' =>'最后登陆Ip'
        ]; // TODO: Change the autogenerated stub
    }

    public function beforeSave($insert)//保存前执行
    {
        if ($insert) {//如果是添加，就加密和添加时间
            //密码加密
            $this->password_hash = \yii::$app->security->generatePasswordHash($this->password);
            //将创建时间和跟新时间自动转换之间戳
            $this->created_at = date("Y-m-d H:i:s", time());
        } else {
            if ($this->password) {
                $this->password_hash = \yii::$app->security->generatePasswordHash($this->password);//更新时加密
            }
            $this->updated_at = date('Y-m-d H:i:s', time());//否则为跟新时间
        }
        return parent::beforeSave($insert);
    }
    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
//    通过给定的ID找到一个标识。
//@param字符串int$id要查找的id
//@return标识接口，匹配给定ID的标识对象。
//如果无法找到这样的标识，则应该返回Null
//或者，标识不处于活动状态(禁用、删除等)。
    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
        // TODO: Implement findIdentity() method.
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     * 通过给定的令牌找到一个标识。
     * @param和 $token混合 $令牌
     * @param混合 $类型的标记类型 。这个参数的值取决于实现。
     * 例如，yii筛选验证HttpBearerAuth将把这个参数设置为yii过滤验证HttpBearerAuth。
     * @return标识接口，与给定的令牌相匹配的标识对象。
     * 如果无法找到这样的标识，则应该返回Null
     * 或者，标识不处于活动状态(禁用、删除等)。
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
//
//返回一个惟一标识用户标识的ID。
    public function getId()
    {
        //获取id
        return $this->id;

        // TODO: Implement getId() method.
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     * 译文：
     * 返回一个可用于检查给定标识ID有效性的密钥。
     *
     * 对于每个单独的用户来说，键应该是惟一的，并且应该是持久的。
     * 这样它就可以用来检查用户身份的有效性。
     *
     * 这些密钥的空间应该足够大，足以挫败潜在的身份攻击。
     *
     * 如果用户::启用了启用自动签名，那么这是必需的。
     * @return字符串，用于检查给定标识ID的有效性。
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        //获取蜜月
        return $this->auth_key;
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        //验证比对密钥
        return $this->auth_key == $authKey;
        // TODO: Implement validateAuthKey() method.
    }

    //获取角色返回到添加用户列表
    public static function getRoles()
    {
        //获取角色
        $roles = \yii::$app->authManager->getRoles();
        //返回给添加页面
        return ArrayHelper::map($roles, 'name', 'description');
    }

    //为用户添加角色
    public function getAddrole()
    {
        //实例化组件
        $authManager = \yii::$app->authManager;
        //获取当前角色
        $roles = $this->roles;
        if ($roles) {
            foreach ($roles as $role) {
                //获取角色
                $roless = $authManager->getRole($role);
                //为用户通过id分配角色
                $authManager->assign($roless, $this->id);
            }
        } else {
            return false;
        }
    }

    //获取角色名称
    public function getRole($id)
    {
        //得到当前角色名称
        $roles = \yii::$app->authManager->getRolesByUser($id);
        $role = array_keys($roles);
        $this->roles = $role;
    }
    //建立对象之间的关系
    public function getChildrens(){
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }
    //导航菜单列表
    public function getMenuItems(){
        $menuItems = [];
        $menus = Menu::findAll(['parent_id'=>0]);
        foreach ($menus as $menu){
            $children = Menu::findAll(['parent_id'=>$menu->id]);
            $items = [];
            //4遍历所有子菜单
            foreach ($children as $child){
                //根据用户权限决定是否添加到items里面
                if(Yii::$app->user->can($child->url)){
                    $items[] = ['label' =>$child->name, 'url' => [$child->url]];
                }
            }
            $menuItems[] = ['label'=>$menu->name,'items'=>$items];
        }
        return $menuItems;
    }
//    public function getMenuItems(){
//        $menuItems = [];
//        //二级菜单演示
//        //1 . 获取所有一级菜单
//        $menus = Menu::findAll(['parent_id'=>0]);
//        //2 遍历一级菜单
//        foreach ($menus as $menu){
////                        var_dump($menu['id']);exit;
//            //3.获取该一级菜单的所有子菜单
//            $children = Menu::findAll(['parent_id'=>$menu['id']]);
//
//            $items = [];
//            //4遍历所有子菜单
//            foreach ($children as $child){
//                //根据用户权限决定是否添加到items里面
//                if(Yii::$app->user->can($child->url)){
//                    $items[] = ['label' =>$child->name, 'url' => [$child->url]];
//                }
//            }
////                        var_dump($items);exit;
////            如果有才显示
//            if(!$items==[]){
//                $menuItems[] = ['label'=>$menu->name,'items'=>$items];
//            }
//        }
//        return $menuItems;
//    }
        // ==============================================================
    }










