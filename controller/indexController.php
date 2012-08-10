<?php

// controllerクラス
require_once '../core/Controller.php';

// 用いるModel群
require_once '../model/indexModel.php';

class indexController extends Controller {
    function control($path) {
        $params = array();
        
        $model = new indexModel($this);
        $params += $model->getParams();
        
        echo $this->_view->render($path, $params);
    }
}
