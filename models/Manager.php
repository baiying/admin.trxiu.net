<?php

namespace app\models;

use Yii;
use yii\base\Object;

class Manager extends Object {
    public $id;
    public $name;
    public $token;
    private $cookieName = "manager";
    /**
     * login
     * 管理员登录
     * @param unknown $username
     * @param unknown $password
     * @param string $remember
     * @return multitype:boolean string |multitype:boolean unknown
     */
    public function login($username, $password, $remember = false) {
        $res = Yii::$app->api->post('manager/login', ['username'=>$username, 'password'=>$password]);
        if($res['code'] == 200) {
            $manager = $res['data'];
            $this->id = $manager['manager_id'];
            $this->name = $manager['username'];
            $this->token = $manager['auth_token'];
            $this->saveToCookie($this, $remember);
            return ['status'=>true, 'message'=>'登录成功'];
        } else {
            return ['status'=>false, 'message'=>$res['message']];
        }
    }
    /**
     * isLogin
     * 判断管理员是否登录
     * @return Ambigous <NULL, \app\models\Manager>
     */
    public function isLogin() {
        return $this->readFromCookie();
    }
    /**
     * logout
     * 管理员登出
     * @param unknown $url
     */
    public function logout($url = '') {
        Yii::$app->cookie->remove($this->cookieName);
        header("Location:{$url}");
        exit;
    }
    /**
     * 管理员身份信息保存到cookie中
     * @param unknown $manager
     * @param string $remember
     */
    private function saveToCookie($manager, $remember = false) {
        $managerStr = $this->id."|".$this->name."|".$this->token;
        $expire = $remember ? time() + (86400 * 30) : null;
        return Yii::$app->cookie->setValue([
            'name' => $this->cookieName,
            'value' => $managerStr,
            'expire' => $expire
        ]);
    }
    /**
     * 从cookie中读取管理员身份信息
     * @return NULL|\app\models\Manager
     */
    private function readFromCookie() {
        if(!Yii::$app->cookie->has($this->cookieName)) return null;
        $managerStr = Yii::$app->cookie->getValue($this->cookieName);
        list($this->id, $this->name, $this->token) = explode("|", $managerStr);
        return $this;
    }
}
