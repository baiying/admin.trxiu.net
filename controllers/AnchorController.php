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
        $this->js[] = "http://jssdk.demo.qiniu.io/bower_components/plupload/js/moxie.js";
        $this->js[] = "http://jssdk.demo.qiniu.io/bower_components/plupload/js/plupload.min.js";
        $this->js[] = "http://jssdk.demo.qiniu.io/bower_components/plupload/js/i18n/zh_CN.js";
        $this->js[] = "/js/common/qiniu.js";
        $this->css[] = "/media/css/jquery.fileupload-ui.css";

        $renderArgs = [];
        // 处理传入参数
        $rule = [
            'page'      => ['type'=>'int', 'default'=>1],
            'size'  => ['type'=>'int', 'default'=>20],
            'order'     => ['type'=>'string', 'default'=>'manager_id DESC']
        ];
        $args = $this->getRequestData($rule, Yii::$app->request->get());

        // 获取主播信息
        $res = Yii::$app->api->get('anchor/get-anchor-list', $args);
        if($res['code'] != 200) {
            $renderArgs['error'] = $res['message'];
            return $this->render('/site/error', $renderArgs);
        }
        $pagecount = $res['data']['pagecount'];
        // 获取主播对应的普通用户信息
        $renderArgs['anchor'] = $res['data']['list'];
        // 生成翻页HTML
        $pageUrl = '/anchor/index/?page=$page';
        $renderArgs['pageBar'] = Yii::$app->utils->getPaging($pageUrl, $args['page'], $pagecount);
        return $this->render('index', $renderArgs);
    }
    /**
     * 主播动态管理页面
     * @return Ambigous <string, string>
     */
    public function actionNews() {
        $this->css[] = "/media/css/blog.css";
        $this->js[] = "http://jssdk.demo.qiniu.io/bower_components/plupload/js/moxie.js";
        $this->js[] = "http://jssdk.demo.qiniu.io/bower_components/plupload/js/plupload.min.js";
        $this->js[] = "http://jssdk.demo.qiniu.io/bower_components/plupload/js/i18n/zh_CN.js";
        $this->js[] = "/js/common/qiniu.js";
        $this->js[] = "/js/anchor/news.js";
        
        $rule = [
            'anchor_id' => ['type'=>'int', 'required'=>true],
            'page'      => ['type'=>'int', 'required'=>false, 'default'=>1],
            'size'      => ['type'=>'int', 'required'=>false, 'default'=>20]
        ];
        $args = $this->getRequestData($rule, Yii::$app->request->get());
        $renderArgs = $args;
        // 获取该主播的最新动态
        $res = Yii::$app->api->get('news/get-anchor-news', $args);
        if($res['code'] == 200 && !empty($res['data']['list'])) {
            $renderArgs['news'] = $res['data']['list'];
        }
        $totalNews = $res['count'];
        
        // 获取当前主播信息
        $res = Yii::$app->api->get('anchor/get-anchor-information', ['anchor_id'=>$args['anchor_id']]);
        if($res['code'] == 200 && !empty($res['data'])) {
            $renderArgs['anchor'] = $res['data'];
        }
        // 生成翻页条HTML
        $pageUrl = '/anchor/news/?anchor_id='.$args['anchor_id'].'&page=$page';
        $maxPage = ceil($totalNews / $args['size']);
        $renderArgs['pageBar'] = Yii::$app->utils->getPaging($pageUrl, $args['page'], $maxPage);
        return $this->render("news", $renderArgs);
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
            // 发布主播动态    
            case 'publishNews':
                $rule = [
                    'anchor_id' => ['type' => 'int', 'required' => true],
                    'content'   => ['type' => 'string', 'required' => true],
                    'images'    => ['type' => 'string', 'required' => false],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->post());
                $res = Yii::$app->api->post('news/add-anchor-news', $args);
                if ($res['code'] == 200) {
                    $json = ['status' => 'success', 'message' => $res['message']];
                } else {
                    $json = ['status' => 'fail', 'message' => $res['message']];
                }
                exit(Json::encode($json));
                break;
            // 修改主播动态
            case 'editNews':
                $rule = [
                    'news_id' => ['type' => 'int', 'required' => true],
                    'content'   => ['type' => 'string', 'required' => true],
                    'images'    => ['type' => 'string', 'required' => false],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->post());
                $res = Yii::$app->api->post('news/edit-anchor-news', $args);
                if ($res['code'] == 200) {
                    $json = ['status' => 'success', 'message' => $res['message']];
                } else {
                    $json = ['status' => 'fail', 'message' => $res['message']];
                }
                exit(Json::encode($json));
                break;
            // 删除主播动态
            case 'delNews':
                $rule = [
                    'news_id' => ['type' => 'int', 'required' => true],
                    'anchor_id'   => ['type' => 'int', 'required' => true],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->post());
                $res = Yii::$app->api->post('news/del-news', $args);
                if ($res['code'] == 200) {
                    $json = ['status' => 'success', 'message' => $res['message']];
                } else {
                    $json = ['status' => 'fail', 'message' => $res['message']];
                }
                exit(Json::encode($json));
                break;
            // 删除动态评论
            case 'denNewsComment':
                $rule = [
                    'comment_id' => ['type' => 'int', 'required' => true],
                    'fans_id'   => ['type' => 'int', 'required' => true],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->post());
                $res = Yii::$app->api->post('news/del-news-comment', $args);
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
