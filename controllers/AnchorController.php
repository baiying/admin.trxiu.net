<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\BaseController;

class AnchorController extends BaseController {

    public $layout = "main";

    public function actionIndex() {
        return $this->render('index');
    }

}
