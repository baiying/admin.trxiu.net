<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use app\controllers\BaseController;

class BallotController extends BaseController {

    public $layout = "main";

    public function actionIndex() {
        $this->js[] = "/js/ballot/index.js";
        $this->css[] = "/media/css/DT_bootstrap.css";

        $renderArgs = [];
        // 处理传入参数
        $rule = [
            'page'      => ['type'=>'int', 'default'=>1],
            'size'  => ['type'=>'int', 'default'=>5],
            'order'     => ['type'=>'string', 'default'=>'manager_id DESC']
        ];
        $args = $this->getRequestData($rule, Yii::$app->request->get());

        // 获取管理员账号信息
        $res = Yii::$app->api->get('ballot/get-ballot-list', $args);
        if($res['code'] != 200) {
            $renderArgs['error'] = $res['message'];
            return $this->render('/site/error', $renderArgs);
        }
        // 将管理员列表数据放入renderArgs数组
        $renderArgs['ballot'] = $res['data']['list'];
        // 生成翻页HTML
        $pageUrl = '/ballot/index/?page=$page';
        $renderArgs['pageBar'] = Yii::$app->utils->getPaging($pageUrl, $args['page'], $res['data']['pagecount']);
//        echo json_encode($renderArgs);exit;
        return $this->render('index', $renderArgs);
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
            // 创建新活动
            case 'createBallot':
                $rule = [
                    'ballot_name' => ['type'=>'string', 'required'=>true],
                    'description' => ['type'=>'string', 'required'=>true],
                    'begin_time' => ['type'=>'int', 'required'=>false],
                    'end_time' => ['type'=>'int', 'required'=>false],
                    'status' => ['type'=>'int', 'required'=>false,'default'=>1],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->get());
                $res = Yii::$app->api->get('ballot/init-ballot', $args);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message']];
                }
                exit(Json::encode($json));
                break;
            // 修改活动信息
            case 'editBallot':
                $rule = [
                    'ballot_id' => ['type'=>'int', 'required'=>true],
                    'ballot_name' => ['type'=>'string', 'required'=>false],
                    'description' => ['type'=>'string', 'required'=>false],
                    'begin_time' => ['type'=>'int', 'required'=>false],
                    'end_time' => ['type'=>'int', 'required'=>false],
                    'status' => ['type'=>'int', 'required'=>false],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->get());
                $res = Yii::$app->api->get('ballot/up-ballot', $args);
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
                    'ballot_id' => ['type'=>'int', 'required'=>true],
                    'status' => ['type'=>'int', 'required'=>true],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->get());
                $res = Yii::$app->api->get('ballot/up-ballot', $args);
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
