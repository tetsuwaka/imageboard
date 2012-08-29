<?php

require_once '../core/Model.php';

require_once '../dbmanager/Image.php';

class commentModel extends Model {

    protected $dbmanager;

    public function __construct() {
        $this->dbmanager = new imageDB();
        $this->dbmanager->connect(array(
            'dsn' => 'mysql:dbname=imageboard;host=127.0.0.1',
            'user' => 'user',
            'password' => 'pass'
        ));
    }

    public function writeComment($comment, $threadid, $name = null) {
        if (!empty($comment)) {
            $this->dbmanager->setComment($comment, $threadid, $name);
        }
    }

    public function getCommentList($threadid) {
        return $this->dbmanager->getCommentsById($threadid);
    }
}