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
}