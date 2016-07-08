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
        Yii::$app->api->post('ballot/change-status');
    }
    /**
     * send-red-package
     * 发送拉票红包
     * 发送规则：每5秒钟选择一个最早领取的红包进行发送
     */
    public function actionSendRedPackage() {
        Yii::$app->api->get('canvass/send-red-package');
    }
}