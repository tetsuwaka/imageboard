<?php

// controllerクラス
require_once '../core/Controller.php';

// 用いるModel群
require_once '../model/indexModel.php';
require_once '../model/commentModel.php';

class indexController extends Controller {
    function control($path) {

        // ポストされていたら、コメントモデルを呼ぶ
        if ($this->isPost() && $this->isAccept()) {
            $name = $this->getPost('name');
            $comment = $this->getPost('comment');
            $threadid = $this->getPost('threadid');
            $commentModel = new commentModel($this);
            $commentModel->writeComment($comment, $threadid, $name);
        }

        $ticket = $this->mkTicket();

        $params = array('ticket' => $ticket);
        $this->setSession('ticket', $ticket);
        
        $num = $this->getGet('number');
        if (!empty($num)) {
            $params['number'] = $num;
        }
        
        $model = new indexModel($this);
        $params += $model->getParams($num);
        echo $this->_view->render($path, $params);
    }
}
