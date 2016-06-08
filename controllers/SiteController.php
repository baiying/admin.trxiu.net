<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\BaseController;

class SiteController extends BaseController {

    public $layout = "main";
    
    public function actionIndex() {
        return $this->render('index');
    }
    
    public function actionLogout() {
        $this->manager->logout("/account/login/");
    }

}
