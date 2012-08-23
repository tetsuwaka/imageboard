<?php

// controllerクラス
require_once '../core/Controller.php';

// 用いるModel群
require_once '../model/drawModel.php';

class drawController extends Controller {
    function control($path) {
        // ポストされていたら、モデルを呼ぶ
        if ($this->isPost() && $this->isAccept()) {
            $params = array();
        } else {
            header('Location: http://tetsuone.rackbox.net/imageboard/');
        }
        $params = array();
        $model = new drawModel($this);
        $params += $model->getParams();
        echo $this->_view->render($path, $params);
    }
}
