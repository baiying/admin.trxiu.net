<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use app\controllers\NoauthBaseController;
use app\models\Manager;

class AccountController extends NoauthBaseController {
    
    public $layout = "blank";
    /**
     * 登录页面
     * @return Ambigous <string, string>
     */
    public function actionLogin() {
        $this->js[] = "/js/account/login.js";
        $renderArgs = [];
        return $this->render('login', $renderArgs);
    }
    
    public function actionInfo() {
        phpinfo();
    }
    /**
     * Ajax请求处理
     */
    public function actionAjax() {
        if(!Yii::$app->request->get('act')) {
            $json = ['status'=>'fail', 'message'=>'缺少act参数'];
            exit();
        }
        $act = Yii::$app->request->get('act');
        switch($act) {
            case 'login':
                if(Yii::$app->request->post('username') && Yii::$app->request->post('password')) {
                    $username = Yii::$app->request->post('username');
                    $password = Yii::$app->request->post('password');
                    $remember = Yii::$app->request->post('remember') ? true : false;
                
                    if(!$this->checkDataFormat('username', $username) || !$this->checkDataFormat('password', $password)) {
                        $json = ['status'=>'fail', 'message'=>'登录名或密码中包含非法字符'];
                    } else {
                        $manager = new Manager();
                        $res = $manager->login($username, $password, $remember);
                        if($res['status']) {
                            $json = ['status'=>'success', 'message'=>'身份验证成功'];
                            
                        } else {
                            $json = ['status'=>'fail', 'message'=>$res['message']];
                        }
                    }
                    
                } else {
                    $json = ['status'=>'fail', 'message'=>'登录名和密码必须完整填写'];
                }
                exit(Json::encode($json));
                break;
        }
    }
    /**
     * 检查数据格式是否合法
     * @param unknown $type
     * @param unknown $value
     * @return boolean
     */
    private function checkDataFormat($type, $value) {
        switch($type) {
            case 'username':
                $rule = "/^[\x{4e00}-\x{9fa5}A-Za-z0-9]+$/u";
                break;
            case 'password':
                $rule = "/^[A-Za-z0-9]+$/u";
                break;
        }
        if(!preg_match($rule, $value)) {
            return false;
        } else {
            return true;
        }
    }
}