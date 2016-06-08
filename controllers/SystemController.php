<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\BaseController;

class SystemController extends BaseController {

    public $layout = "main";
    
    public function actionManager() {
        $this->js[] = "/js/system/manager.js";
        
        $renderArgs = [];
        // 处理传入参数
        $rule = [
            'page'      => ['type'=>'int', 'default'=>1],
            'pagesize'  => ['type'=>'int', 'default'=>20],
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
    
}
