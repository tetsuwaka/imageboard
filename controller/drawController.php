<?php

// controllerクラス
require_once '../core/Controller.php';

// 用いるModel群
require_once '../model/drawModel.php';
require_once '../model/saveImageModel.php';

class drawController extends Controller {
    function control($path) {
        // ポストされていたら、モデルを呼ぶ
        if ($this->isPost() && $this->isAccept()) {
            if (!empty($this->getPost('image'))) {
                $image = $this->getPost('image');
                $name = $this->getPost('name');
                $saveImageModel = new saveImageModel($this);
                $saveImageMode->save($image, $name);
                header('Location: http://tetsuone.rackbox.net/imageboard/');
            }
        } else {
            header('Location: http://tetsuone.rackbox.net/imageboard/');
        }

        $ticket = $this->mkTicket();

        $params = array('ticket' => $ticket);
        $this->setSession('ticket', $ticket);

        $model = new drawModel($this);
        $params += $model->getParams();
        echo $this->_view->render($path, $params);
    }
}
