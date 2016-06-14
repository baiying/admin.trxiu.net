<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\BaseController;

class FansController extends BaseController {

    public $layout = "main";

    public function actionIndex() {
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
//        echo json_encode($renderArgs);exit;
        return $this->render('index', $renderArgs);
    }

}
