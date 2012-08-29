<?php

// controllerクラス
require_once '../core/Controller.php';

// 用いるModel群
require_once '../model/commentModel.php';

class commentController extends Controller {
    function control($path) {

        // ポストされていたら、コメントモデルを呼ぶ
        if ($this->isPost() && $this->isAccept()) {
            $name = $this->getPost('name');
            $comment = $this->getPost('comment');
            $threadid = $this->getPost('threadid');
            $commentModel = new commentModel($this);
            $commentModel->writeComment($comment, $threadid, $name);

            $comments = $commentModel->getCommentList($threadid);
            $params = array('comments' => $comments);
            echo $this->_view->render($path, $params);
        }
    }
}