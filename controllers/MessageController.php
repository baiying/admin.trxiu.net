<?php
/**
 * Created by PhpStorm.
 * User: Maple
 * Date: 16/6/29
 * Time: 13:33
 */

namespace app\controllers;


use Yii;
use yii\web\Controller;
use app\controllers\BaseController;
use yii\helpers\Json;

class MessageController extends BaseController
{
    public $layout = "main";
    
    /**
     * 消息列表页
     */
    public function actionIndex(){
        $this->js[] = "/js/message/message.js";
//        $this->css[] = "/media/css/DT_bootstrap.css";
        // 处理传入参数
        $rule = [
            'page'=> ['type'=>'int', 'default'=>1],
            'size'=> ['type'=>'int', 'default'=>10],
        ];
        $args = $this->getRequestData($rule, Yii::$app->request->get());

        // 获取管理员账号信息
        $res = Yii::$app->api->get('message/get-all-message-list', $args);
        if($res['code'] != 200) {
            $renderArgs['error'] = $res['message'];
            return $this->render('/site/error', $renderArgs);
        }
        $result['messageList'] = $res['data']['list'];
        // 生成翻页HTML
        $pageUrl = '/message/index/?page=$page';
        $result['pageBar'] = Yii::$app->utils->getPaging($pageUrl, $args['page'], $res['data']['pagecount']);
        return $this->render('index', $result);
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
            case 'addMessageAtAll':
                $rule = [
                    'send_fans_id' => ['type'=>'int', 'required'=>true],
                    'content' => ['type'=>'string', 'required'=>true],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->get());
                $res = Yii::$app->api->post('message/add-message-at-all', $args);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message']];
                }
                exit(Json::encode($json));
                break;
            case 'fansList' :
                $res = Yii::$app->api->get('fans/get-fans-list',['all_list'=>'all']);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message'],'data'=>$res['data']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message']];
                }
                exit(Json::encode($json));
                break;
            case 'addMessageMore':
                $rule = [
                    'fans_id_list' => ['type'=>'string', 'required'=>true],
                    'send_fans_id' => ['type'=>'int', 'required'=>true],
                    'content' => ['type'=>'string', 'required'=>true],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->post());
                $res = Yii::$app->api->post('message/add-message-more', $args);
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