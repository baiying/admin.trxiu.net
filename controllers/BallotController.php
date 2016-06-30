<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use app\controllers\BaseController;

class BallotController extends BaseController {

    public $layout = "main";

    /**
     * 活动管理
     */
    public function actionIndex() {
        // 引入datetimepicker组件使用的样式文件及js脚本文件
        $this->css[] = "/media/css/datetimepicker.css";
        $this->js[] = "/media/js/bootstrap-datetimepicker.js";
        $this->js[] = "/media/js/app.js";
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
     * 活动主播管理
     */
    public function actionAnchor() {
        $this->js[] = "/js/ballot/ballotAnchor.js";
        $this->css[] = "/media/css/DT_bootstrap.css";

        $renderArgs = [];
        // 处理传入参数
        $rule = [
            'ballot_id'  => ['type'=>'int', 'required'=>true],
            'page' => ['type'=>'int', 'default'=>1],
            'size' => ['type'=>'int', 'default'=>5],
            'order' => ['type'=>'string', 'default'=>'manager_id DESC']
        ];
        $args = $this->getRequestData($rule, Yii::$app->request->get());

        // 获取管理员账号信息
        $res = Yii::$app->api->get('ballot/get-ballot-detail', $args);
        if($res['code'] != 200) {
            $renderArgs['error'] = $res['message'];
            return $this->render('/site/error', $renderArgs);
        }
        // 将管理员列表数据放入renderArgs数组
        $renderArgs['ballotAnchor'] = $res['data']['anchorList'];
        $renderArgs['ballotId'] = $res['data']['ballot_id'];

        return $this->render('ballotAnchor', $renderArgs);
    }
    /**
     * 主播投票详情页
     */
    public function actionAnchorVote() {
        $renderArgs = [];
        $rule = [
            'ballot_id' => ['type'=>'int', 'required'=>true],
            'anchor_id' => ['type'=>'int', 'required'=>true],
            'type'      => ['type'=>'string', 'required'=>false, 'default'=>'free'],
            'page'      => ['type'=>'int', 'required'=>false, 'default'=>1]
        ];
        $args = $this->getRequestData($rule, Yii::$app->request->get());
        $renderArgs = $args;
        // 获取活动基本信息
        $res = Yii::$app->api->get('ballot/info', $args);
        if($res['code'] != 200) {
            $this->errors[] = $res['message'];
        }
        if(empty($res['data'])) {
            $this->errors[] = "未查找到活动信息";
        }
        if(!empty($this->errors)) {
            return $this->render('/site/error', ['errors'=>$this->errors]);
        }
        $renderArgs['ballot'] = $res['data'];
        
        // 获取主播基本信息
        $res = Yii::$app->api->get('anchor/get-anchor-information', $args);
        if($res['code'] != 200) {
            $this->errors[] = $res['message'];
        }
        if(empty($res['data'])) {
            $this->errors[] = "未查找到主播信息";
        }
        if(!empty($this->errors)) {
            return $this->render('/site/error', ['errors'=>$this->errors]);
        }
        $renderArgs['anchor'] = $res['data'];
        
        $pagesize = 20;
        $count = 0;
        if($args['type'] == 'free' || $args['type'] == 'pay') {
            $res = $this->getAnchorVote($args['ballot_id'], $args['anchor_id'], $args['page'], $args['type']);
            if(empty($res)) {
                $renderArgs['votes'] = [];
            } else {
                $count = $res['count'];
                $renderArgs['votes'] = $res['data'];
            }
            
        } else {
            $res = $this->getAnchorCanvass($args['ballot_id'], $args['anchor_id'], $args['page']);
            if(empty($res)) {
                $renderArgs['canvass'] = [];
            } else {
                $count = $res['count'];
                $renderArgs['canvass'] = $res['data'];
            }
        }
        
        // 生成翻页HTML
        if($count > 0) {
            $pageUrl = '/ballot/anchor-vote/?ballot_id='.$args['ballot_id'].'&anchor_id='.$args['anchor_id'].'&type='.$args['type'].'&page=$page';
            $renderArgs['pageBar'] = Yii::$app->utils->getPaging($pageUrl, $args['page'], ceil($count / $pagesize));
        }
        return $this->render('vote', $renderArgs);
    }
    /**
     * 活动奖项设置页面
     * @return Ambigous <string, string>
     */
    public function actionPrize() {
        $this->js[] = "/js/ballot/prize.js";
        $this->js[] = "http://jssdk.demo.qiniu.io/bower_components/plupload/js/moxie.js";
        $this->js[] = "http://jssdk.demo.qiniu.io/bower_components/plupload/js/plupload.min.js";
        $this->js[] = "http://jssdk.demo.qiniu.io/bower_components/plupload/js/i18n/zh_CN.js";
        $this->js[] = "/js/common/qiniu.js";
        $this->css[] = "/media/css/DT_bootstrap.css";
        
        $renderArgs = [];
        // 处理传入参数
        $rule = [
            'ballot_id'  => ['type'=>'int', 'required'=>true],
        ];
        $args = $this->getRequestData($rule, Yii::$app->request->get());
        
        // 获取本活动的奖项设置信息
        $res = Yii::$app->api->get('ballot-prize/search', $args);
        if($res['code'] != 200) {
            $renderArgs['error'] = $res['message'];
            return $this->render('/site/error', $renderArgs);
        }
        
        $renderArgs['ballot_id'] = $args['ballot_id'];
        $renderArgs['prizes'] = $res['data'];
        
        return $this->render('prize', $renderArgs);
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
                    'begin_time' => ['type'=>'string', 'required'=>false],
                    'end_time' => ['type'=>'string', 'required'=>false],
                    'status' => ['type'=>'int', 'required'=>false],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->get());
                if(isset($args['begin_time'])){
                    $args['begin_time'] = strtotime($args['begin_time']);
                }
                if(isset($args['end_time'])){
                    $args['end_time'] = strtotime($args['end_time']);
                }
                $res = Yii::$app->api->get('ballot/up-ballot', $args);
//                echo json_encode($res);exit;
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
            // 获取主播列表
            case 'getAnchorList':
                $args = [
                    'size' => 'max',
                ];
                $res = Yii::$app->api->get('anchor/get-anchor-list',$args);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message'],'data'=>$res['data']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message']];
                }
                exit(Json::encode($json));
                break;
            case 'addAnchor':
                $rule = [
                    'anchor_id' => ['type'=>'int', 'required'=>true],
                    'ballot_id' => ['type'=>'int', 'required'=>true],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->get());
                $res = Yii::$app->api->get('ballot/ballot-add-anchor',$args);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message'],'data'=>$res['data']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message']];
                }
                exit(Json::encode($json));
                break;
            // 添加活动奖项设置    
            case 'createPrize':
                $rule = [
                    'level' => ['type'=>'string', 'required'=>true],
                    'title' => ['type'=>'string', 'required'=>true],
                    'ballot_id' => ['type'=>'int', 'required'=>true],
                    'sort' => ['type'=>'int', 'required'=>true],
                    'logo' => ['type'=>'string', 'required'=>true],
                    'image' => ['type'=>'string', 'required'=>true],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->post());
                $res = Yii::$app->api->post('ballot-prize/create', $args);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message'],'data'=>$res['data']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message']];
                }
                exit(Json::encode($json));
                break;
            // 添加活动奖项设置
            case 'updatePrize':
                $rule = [
                    'prize_id' => ['type'=>'int', 'required'=>true],
                    'level' => ['type'=>'string', 'required'=>true],
                    'title' => ['type'=>'string', 'required'=>true],
                    'sort' => ['type'=>'int', 'required'=>true],
                    'logo' => ['type'=>'string', 'required'=>true],
                    'image' => ['type'=>'string', 'required'=>true],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->post());
                $res = Yii::$app->api->post('ballot-prize/update', $args);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message'],'data'=>$res['data']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message']];
                }
                exit(Json::encode($json));
                break;
                
            case 'deletePrize':
                $rule = [
                    'prize_id' => ['type'=>'int', 'required'=>true],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->post());
                $res = Yii::$app->api->post('ballot-prize/delete', $args);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message'],'data'=>$res['data']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message']];
                }
                exit(Json::encode($json));
                break;
            // 主播退赛
            case 'remove':
                $rule = [
                    'anchor_id' => ['type'=>'int', 'required'=>true],
                    'ballot_id' => ['type'=>'int', 'required'=>true],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->get());
                $res = Yii::$app->api->get('ballot/ballot-del-anchor',$args);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message'],'data'=>$res['data']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message']];
                }
                exit(Json::encode($json));
                break;
            // 修正主播票数
            case 'votes_amend':
                $rule = [
                    'ballot_anchor_id' => ['type'=>'int', 'required'=>true],
                    'amend_num' => ['type'=>'int', 'required'=>true],
                ];
                $args = $this->getRequestData($rule, Yii::$app->request->get());
                $res = Yii::$app->api->get('ballot/up-votes-amend',$args);
                if($res['code'] == 200) {
                    $json = ['status'=>'success', 'message'=>$res['message'],'data'=>$res['data']];
                } else {
                    $json = ['status'=>'fail', 'message'=>$res['message']];
                }
                exit(Json::encode($json));
                break;
        }
    }
    /**
     * getAnchorVote
     * 获取粉丝投票明细
     * @param number $ballotId  活动ID
     * @param number $anchorId  主播ID
     * @param number $page      页码
     * @param string $type      投票类型，free 免费投票，pay 拉票投票
     * @return multitype:|multitype:unknown
     */
    private function getAnchorVote($ballotId, $anchorId, $page = 1, $type = 'free') {
        $res = Yii::$app->api->get('vote/search', [
            'ballot_id' => $ballotId,
            'anchor_id' => $anchorId,
            'page'      => $page,
            'type'      => $type
        ]);
        if($res['code'] != 200 || empty($res['data'])) {
            return [];
        } else {
            return [
                'count' => $res['count'],
                'data'  => $res['data']
            ];
        }
    }
    /**
     * getAnchorCanvass
     * 获取为主播拉票的记录
     * @param number $ballotId  活动ID
     * @param number $anchorId  主播ID
     * @param number $page      页码
     * @param string $type      投票类型，free 免费投票，pay 拉票投票
     * @return multitype:|multitype:unknown
     */
    private function getAnchorCanvass($ballotId, $anchorId, $page = 1) {
        $res = Yii::$app->api->get('canvass/search', [
            'ballot_id' => $ballotId,
            'anchor_id' => $anchorId,
            'page'      => $page
        ]);
        if($res['code'] != 200 || empty($res['data'])) {
            return [];
        } else {
            return [
                'count' => $res['count'],
                'data'  => $res['data']
            ];
        }
    }
}
