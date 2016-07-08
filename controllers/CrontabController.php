<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class CrontabController extends Controller {
    /**
     * cron-ballot-status
     * 更新活动状态
     */
    public function actionCronBallotStatus() {
        Yii::$app->api->get('ballot/change-status');
    }
    /**
     * send-red-package
     * 发送拉票红包
     * 发送规则：每10秒钟选择一个最早领取的红包进行发送
     */
    public function actionSendRedPackage() {
        Yii::$app->api->get('canvass/send-red-package');
    }
    /**
     * send-cashback-red
     * 发送拉票返现红包
     */
    public function actionSendCashbackRed() {
        Yii::$app->api->get('canvass/send-cashback-red');
    }
}