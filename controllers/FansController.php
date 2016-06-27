<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\BaseController;
use yii\helpers\Json;

class FansController extends BaseController {

    public $layout = "main";

    public function actionIndex() {
        $this->js[] = "http://jssdk.demo.qiniu.io/bower_components/plupload/js/moxie.js";
        $this->js[] = "http://jssdk.demo.qiniu.io/bower_components/plupload/js/plupload.dev.js";
        $this->js[] = "http://jssdk.demo.qiniu.io/src/qiniu.js";
        $this->js[] = "/js/fans/index.js";
        $this->css[] = "/media/css/DT_bootstrap.css";

        $renderArgs = [];
        // 处理传入参数
        $rule = [
            'page'=> ['type'=>'int', 'default'=>1],
            'size'=> ['type'=>'int', 'default'=>5],
        ];
        $args = $this->getRequestData($rule, Yii::$app->request->get());

        // 获取管理员账号信息
        $res = Yii::$app->api->get('fans/get-fans-list', $args);
        if($res['code'] != 200) {
            $renderArgs['error'] = $res['message'];
            return $this->render('/site/error', $renderArgs);
        }
        // 将管理员列表数据放入renderArgs数组
        $renderArgs['fansList'] = $res['data']['list'];
        // 生成翻页HTML
        $pageUrl = '/fans/index/?page=$page';
        $renderArgs['pageBar'] = Yii::$app->utils->getPaging($pageUrl, $args['page'], $res['data']['pagecount']);
        return $this->render('index', $renderArgs);
    }


    /**
     * Ajax请求处理
     */
    public function actionAjax() {
        if(!Yii::$app->request->get('act')) {
            exit(Json::encode(['status'=>'fail', 'message'=>'缺少act参数']));
        }
        $act = Yii::$app->request->get('act');
        switch($act) {
            // 创建新活动
            case 'addAnchor':
                $rule = [
                    'fans_id' => ['type'=>'int', 'required'=>true],
                    'backimage' => ['type'=>'string', 'required'=>false],
                    'qrcode' => ['type'=>'string', 'required'=>false],
                    'platform' => ['type'=>'string', 'required'=>false],
                    'broadcast' => ['type'=>'string', 'required'=>false],
                    'description' => ['type'=>'string', 'required'=>false],
                ];
//                echo json_encode(Yii::$app->request->get());exit;
                $args = $this->getRequestData($rule, Yii::$app->request->get());
//                echo json_encode($args);exit;
                $res = Yii::$app->api->get('anchor/add-anchor', $args);
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
