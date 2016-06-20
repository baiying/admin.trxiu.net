<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\BaseController;
use yii\helpers\Json;

class AnchorController extends BaseController {

    public $layout = "main";

    public function actionIndex() {
        $this->js[] = "/js/anchor/index.js";
        $this->css[] = "/media/css/DT_bootstrap.css";

        $renderArgs = [];
        // 处理传入参数
        $rule = [
            'page'      => ['type'=>'int', 'default'=>1],
            'size'  => ['type'=>'int', 'default'=>5],
            'order'     => ['type'=>'string', 'default'=>'manager_id DESC']
        ];
        $args = $this->getRequestData($rule, Yii::$app->request->get());

        // 获取主播信息
        $res = Yii::$app->api->get('anchor/get-anchor-list', $args);
//        echo json_encode($res);exit;
        if($res['code'] != 200) {
            $renderArgs['error'] = $res['message'];
            return $this->render('/site/error', $renderArgs);
        }
//        echo json_encode($res);exit;
        $pagecount = $res['data']['pagecount'];
        // 获取主播对应的普通用户信息
        $renderArgs['anchor'] = $res['data']['list'];
        // 生成翻页HTML
        $pageUrl = '/anchor/index/?page=$page';
        $renderArgs['pageBar'] = Yii::$app->utils->getPaging($pageUrl, $args['page'], $pagecount);
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
            case 'editAnchor':
                $rule = [
                    'anchor_id' => ['type' => 'int', 'required' => true],
                    'anchor_name' => ['type' => 'string', 'required' => false],
                    'thumb' => ['type' => 'string', 'required' => false],
                    'backimage' => ['type' => 'string', 'required' => false],
                    'qrcode' => ['type' => 'string', 'required' => false],
                    'platform' => ['type' => 'string', 'required' => false],
                    'broadcast' => ['type' => 'string', 'required' => false],
                    'description' => ['type' => 'string', 'required' => false],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->get());
                $res = Yii::$app->api->get('anchor/update-anchor', $args);
                if ($res['code'] == 200) {
                    $json = ['status' => 'success', 'message' => $res['message']];
                } else {
                    $json = ['status' => 'fail', 'message' => $res['message']];
                }
                exit(Json::encode($json));
                break;
        }
    }

}
