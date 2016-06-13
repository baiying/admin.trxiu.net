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
            'pagesize'  => ['type'=>'int', 'default'=>2],
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
//        echo json_encode($renderArgs);exit;
        return $this->render('manager', $renderArgs);
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
        }
    }
    
}
