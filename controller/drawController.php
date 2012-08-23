<?php

// controllerクラス
require_once '../core/Controller.php';

// 用いるModel群
//require_once '../model/drawModel.php';

class drawController extends Controller {
    function control($path) {
        // ポストされていたら、モデルを呼ぶ
        if ($this->isPost() && $this->isAccept()) {
            
        } else {
            header('Location: http://tetsuone.rackbox.net/imageboard/');
        }
        $params = array();
        $this->_view->render($path, $params);
    }
}
