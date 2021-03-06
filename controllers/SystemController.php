<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use app\controllers\BaseController;

class SystemController extends BaseController {

    public $layout = "main";
    
    public function actionManager() {
        $this->js[] = "/js/system/manager.js";
        $this->css[] = "/media/css/DT_bootstrap.css";
        
        $renderArgs = [];
        // 处理传入参数
        $rule = [
            'page'      => ['type'=>'int', 'default'=>1],
            'pagesize'  => ['type'=>'int', 'default'=>5],
            'order'     => ['type'=>'string', 'default'=>'manager_id DESC']
        ];
        $args = $this->getRequestData($rule, Yii::$app->request->get());
        
        // 获取管理员账号信息
        $res = Yii::$app->api->get('manager/search', $args);
        if($res['code'] != 200) {
            $renderArgs['error'] = $res['message'];
            return $this->render('/site/error', $renderArgs);
        }
        // 将管理员列表数据放入renderArgs数组
        $renderArgs['managers'] = $res['data'];
        // 生成翻页HTML
        $pageUrl = '/system/manager/?page=$page';
        $maxPage = ceil($res['count'] / $args['pagesize']);
        $renderArgs['pageBar'] = Yii::$app->utils->getPaging($pageUrl, $args['page'], $maxPage);
        return $this->render('manager', $renderArgs);
    }
    
    public function actionSetting() {
        $this->css[] = "/media/css/DT_bootstrap.css";
        $this->css[] = "/media/css/bootstrap-wysihtml5.css";
        $this->js[] = "/media/js/wysihtml5-0.3.0.js";
        $this->js[] = "/media/js/bootstrap-wysihtml5.js";
        $this->js[] = "/js/system/setting.js";
        $this->jsObject[] = "Setting";
        $renderArgs = [];
        
        // 获取系统参数
        $res = Yii::$app->api->get('setting/setting');
        $renderArgs['setting'] = $res['data'];
        return $this->render('setting', $renderArgs);
    }
    /**
     * Ajax请求处理
     */
    public function actionAjax() {
        if(!Yii::$app->request->get('act')) {
            $json = ['status'=>'fail', 'message'=>'缺少act参数'];
            exit(Json::encode($json));
        }
        $act = Yii::$app->request->get('act');
        switch($act) {
            // 注册新的管理员账号
            case 'createManager':
                $rule = [
                    'username' => ['type'=>'string', 'required'=>true],
                    'password' => ['type'=>'string', 'required'=>true],
                    'real_name'=> ['type'=>'string', 'default'=>''],
                    'mobile'   => ['type'=>'string', 'default'=>''],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->post());
                $res = Yii::$app->api->post('manager/register', $args);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message']];
                }
                exit(Json::encode($json));
                break;
            // 编辑已有的管理员账号
            case 'editManager':
                $rule = [
                    'username' => ['type'=>'string', 'required'=>true],
                    'password' => ['type'=>'string', 'required'=>true],
                    'managerid' => ['type'=>'int', 'required'=>true],
                    'real_name'=> ['type'=>'string', 'default'=>''],
                    'mobile'   => ['type'=>'string', 'default'=>''],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->post());
                $res = Yii::$app->api->post('manager/edit', $args);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message']];
                }
                exit(Json::encode($json));
                break;
            // 修改管理员账号状态
            case 'changeStatus':
                $rule = [
                    'managerid' => ['type'=>'int', 'required'=>true],
                    'status' => ['type'=>'int', 'required'=>true],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->post());
                $res = Yii::$app->api->post('manager/change-status', $args);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message']];
                }
                exit(Json::encode($json));
                break;
                
            case 'editSetting':
                $args = [];
                Yii::$app->request->post('fee') && $args['fee'] = floatval(Yii::$app->request->post('fee'));
                Yii::$app->request->post('rule_vote') && $args['rule_vote'] = Yii::$app->request->post('rule_vote');
                Yii::$app->request->post('rule_red') && $args['rule_red'] = Yii::$app->request->post('rule_red');
                $res = Yii::$app->api->post('setting/update', $args);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message'], 'data'=>$res['data']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message'], 'data'=>$res['data']];
                }
                exit(Json::encode($json));
                break;
        }
    }
    
}
